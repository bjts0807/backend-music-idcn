<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\Cancion;
use App\Models\Miembro;
use App\Models\Repertorio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $count_members=Miembro::count();
        $count_canciones=Cancion::count();
        $count_artistas=Artista::count();
        $count_repertorio=Repertorio::count();

        $fecha=Carbon::now('America/Bogota')->format('Y-m-d');

        $repertorio=Repertorio::where('fecha_ejecucion',$fecha)
        ->with(['detalles.miembro','detalles.cancion.detalles'])->first();

        $datos=[
            'total_miembros'=>$count_members,
            'total_canciones'=>$count_canciones,
            'total_artistas'=>$count_artistas,
            'total_repertorio'=>$count_repertorio,
            'repertorio'=>$repertorio
        ];

        return response()->json($datos);
    }
}
