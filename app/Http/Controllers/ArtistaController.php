<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArtistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Artista $model)
    {

        $query = $model->query();

        $query->when($request->has('s'), function($query) use($request){
            $search = trim($request->s);
            $query->where('nombre', 'like', '%' . $search . '%');

        });

        return $request->has('per_page')
        ? $query->paginate($request->per_page)
        : $query->get();
    }

    public function data_source_artista(Request $request)
    {
        $s = $request->s;

        $artista = Artista::selectRaw('id, concat("",nombre) as text')
            ->where('nombre', 'like', '%' . $s . '%')
            ->limit(3)
            ->get();

        return response()->json(['results' => $artista]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $artista = Artista::create([
                'nombre' => strtoupper($request->nombre)
            ]);

            DB::commit();

            return response()->json($artista);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artista=Artista::where('id', $id)->first();
        return response()->json($artista);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            DB::beginTransaction();

            $artista=Artista::find($request->id);
            $artista->nombre=strtoupper($request->nombre);
            $artista->save();

            DB::commit();

            return response()->json($artista);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
