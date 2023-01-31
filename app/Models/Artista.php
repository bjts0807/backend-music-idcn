<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    use HasFactory;
    protected $table = 'artistas';
    protected $fillable = [
        'nombre',
        'imagen'
    ];

    public function canciones(){
        return $this->hasMany('App\Models\Cancion','artista_id','id');
    }
}
