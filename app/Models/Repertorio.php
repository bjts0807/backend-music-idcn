<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repertorio extends Model
{
    use HasFactory;
    protected $table = 'repertorio';
    protected $fillable = [
        'id',
        'nombre',
        'fecha_ensayo',
        'fecha_ejecucion',
    ];

    public function detalles(){
        return $this->hasMany('App\Models\DetalleRepertorio','repertorio_id', 'id');
    }

}
