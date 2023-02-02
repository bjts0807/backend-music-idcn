<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRepertorio extends Model
{
    use HasFactory;
    protected $table = 'detalles_repertorio';
    protected $fillable = [
        'id',
        'repertorio_id',
        'miembro_id',
        'cancion_id',
        'observacion'
    ];

    public function miembro(){
        return $this->belongsTo('App\Models\Miembro','miembro_id', 'id');
    }

    public function cancion(){
        return $this->belongsTo('App\Models\Cancion','cancion_id', 'id');
    }

    public function repertorio(){
        return $this->belongsTo('App\Models\Repertorio','repertorio_id', 'id');
    }
}
