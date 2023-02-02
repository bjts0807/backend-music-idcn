<?php

namespace App\Http\Controllers;

use App\Models\Cancion;
use App\Models\DetalleCancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancionController extends Controller
{
    public function index(Request $request){

        $query = Cancion::query();

        $query->when($request->has('s'), function ($query) use ($request) {
            $search = trim($request->s);
            $query->whereHas('artista', function ($query) use ($search) {
                $query->where('nombre',
                    'like',
                    "%{$search}%"
                );
            })->orWhere('nombre',
                'like',
                "%{$search}%"
            );
        })->orderBy('nombre', 'asc')
        ->with(['artista','detalles']);

        $results = $request->has('per_page') ? $query->paginate($request->per_page) : $query->get();

        return response()->json($results);
    }

    public function store(Request $request){
        try {

            DB::beginTransaction();

            $cancion = Cancion::create([
                'nombre' => strtoupper($request->nombre),
                'artista_id' => $request->artista['id']
            ]);

            foreach($request->detalles as $detalle){
                DetalleCancion::create([
                    'nombre' => strtoupper($detalle['nombre_detalle']),
                    'cancion_id' => $cancion->id,
                    'contenido' => $detalle['contenido'],
                ]);
            }

            DB::commit();

            return response()->json('datos guardados con exito');

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    public function show($id){
        $cancion=Cancion::where('id',$id)->with(['detalles','artista'])->first();
        return response()->json($cancion);
    }

    public function update(Request $request)
    {
        try {

            DB::beginTransaction();

            $cancion=Cancion::find($request->id_cancion);

            $cancion_detalles=DetalleCancion::where('cancion_id',$request->id_cancion)->get();

            foreach($cancion_detalles as $detalles){
                $detalles->delete();
            }

            $cancion->nombre=strtoupper($request->nombre);
            $cancion->artista_id = $request->artista['id'];
            $cancion->save();

            foreach($request->detalles as $detalle){
                DetalleCancion::create([
                    'nombre' => strtoupper($detalle['nombre_detalle']),
                    'cancion_id' => $cancion->id,
                    'contenido' => $detalle['contenido'],
                ]);
            }

            DB::commit();

            return response()->json('datos actualizados');

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    public function data_source_cancion(Request $request)
    {
        $s = $request->s;

        $cancion = Cancion::selectRaw('id, concat("",nombre) as text')
            ->where('nombre', 'like', '%' . $s . '%')
            ->limit(3)
            ->get();

        return response()->json(['results' => $cancion]);
    }
}
