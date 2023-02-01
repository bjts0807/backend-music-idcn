<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCancion extends Model
{
    use HasFactory;
    protected $table = 'detalles_cancion';
    protected $fillable = [
        'nombre',
        'contenido',
        'cancion_id'
    ];

    public function cancion(){
        return $this->belongsTo('App\Models\Cancion','cancion_id','id');
    }
}
