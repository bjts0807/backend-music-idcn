<?php

namespace App\Http\Controllers;

use App\Models\DetalleRepertorio;
use App\Models\Repertorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepertorioController extends Controller
{
    public function index(Request $request){

        $query = Repertorio::query();

        $query->when($request->has('s'), function ($query) use ($request) {
            $search = trim($request->s);
            $query->Where('nombre',
                'like',
                "%{$search}%"
            );
        })
        ->with(['detalles.cancion.detalles','detalles.cancion.artista','detalles.miembro'])
        ->orderBy('fecha_ejecucion','desc');

        $results = $request->has('per_page') ? $query->paginate($request->per_page) : $query->get();

        return response()->json($results);
    }

    public function store(Request $request){
        try {

            DB::beginTransaction();

            $repertorio = Repertorio::create([
                'nombre' => strtoupper($request->nombre),
                'fecha_ensayo' => $request->fecha_ensayo,
                'fecha_ejecucion' => $request->fecha_ejecucion,
            ]);

            foreach($request->detalles as $detalle){
                DetalleRepertorio::create([
                    'observacion' => strtoupper($detalle['observacion']),
                    'repertorio_id' => $repertorio->id,
                    'cancion_id' => $detalle['cancion']['id'],
                    'miembro_id' => $detalle['miembro']['id'],
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
        $repertorio=Repertorio::where('id',$id)->with(['detalles.miembro','detalles.cancion.detalles'])->first();
        return response()->json($repertorio);
    }

    public function update(Request $request){
        try {

            DB::beginTransaction();

            $repertorio=Repertorio::find($request->id_repertorio);

            $detalles_repertorio=DetalleRepertorio::where('repertorio_id',$request->id_repertorio)->get();

            foreach($detalles_repertorio as $detalles){
                $detalles->delete();
            }

            $repertorio->nombre=strtoupper($request->nombre);
            $repertorio->fecha_ejecucion = $request->fecha_ejecucion;
            $repertorio->fecha_ensayo = $request->fecha_ensayo;
            $repertorio->save();

            foreach($request->detalles as $detalle){
                DetalleRepertorio::create([
                    'observacion' => strtoupper($detalle['observacion']),
                    'repertorio_id' => $repertorio->id,
                    'cancion_id' => $detalle['cancion']['id'],
                    'miembro_id' => $detalle['miembro']['id'],
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

    public function destroy($id){

        DetalleRepertorio::where('repertorio_id',$id)->delete();
        Repertorio::where('id',$id)->delete();

        return response()->json('datos eliminados con exitos');
    }
}
