<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'clientes';
    protected $fillable = [
        'nome',
        'cpf',
        'logradouro',
        'cidade',
        'uf',
        'cep',
        'numero',
        'complemento',
        'telefone',
    ];
}
