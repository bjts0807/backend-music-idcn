<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    use HasFactory;
    protected $table = 'canciones';
    protected $fillable = [
        'nombre',
        'artista_id'
    ];

    public function artista(){
        return $this->belongsTo('App\Models\Artista','artista_id','id');
    }

    public function detalles(){
        return $this->hasMany('App\Models\DetalleCancion','cancion_id','id');
    }
}
