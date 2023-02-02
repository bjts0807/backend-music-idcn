<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;
    protected $table = 'miembros';
    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'document_type',
        'document_number',
        'phone',
        'address',
        'email',
        'birthday',
        'active'
    ];

    public function repertorio(){
        return $this->hasMany('App\Models\Repertorio','miembro_id', 'id');
    }
}
