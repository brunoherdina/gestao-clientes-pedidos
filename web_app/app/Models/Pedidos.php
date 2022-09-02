<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = [
        'status_descricao',
        'data_entrega_formatada',
        'data_entrega_prevista_formatada',
        'data_criacao_formatada'
    ];

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

    public function getDataEntregaFormatadaAttribute()
    {
        if($this->data_entrega) {
            $data_entrega = Carbon::createFromFormat('Y-m-d', $this->data_entrega)->format('d/m/Y');
            return $data_entrega;
        }
        return null;
    }

    public function getDataEntregaPrevistaFormatadaAttribute()
    {
        if($this->data_entrega_prevista) {
            $data_entrega_prevista = Carbon::createFromFormat('Y-m-d', $this->data_entrega_prevista)->format('d/m/Y');
            return $data_entrega_prevista;
        }
        return null;
    }

    public function getDataCriacaoFormatadaAttribute()
    {
        if($this->created_at) {
            $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i');
            return $created_at;
        }
        return null;
    }
}
