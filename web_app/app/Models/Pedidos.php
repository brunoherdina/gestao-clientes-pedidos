<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = [
        'id_cliente',
        'valor_frete',
        'data_entrega_prevista',
        'data_entrega',
        'status'
    ];

    protected $appends = ['status_descricao'];

    const PENDENTE = 0;
    const ENTREGUE = 1;
    const EM_ATRASO = 2;
    const CANCELADO = 3;

    const STATUS_PEDIDOS = [
        self::PENDENTE => 'Pendente',
        self::ENTREGUE => 'Entregue',
        self::EM_ATRASO => 'Em atraso',
        self::CANCELADO => 'Cancelado'
    ];

    public function cliente()
    {
        return $this->hasOne(Clientes::class, 'id', 'id_cliente');
    }

    public function getStatusDescricaoAttribute()
    {
        return self::STATUS_PEDIDOS[$this->status] ?? null;
    }
}
