<?php

namespace App\Http\Requests;

use App\Models\Pedidos;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListagemPedidosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_cliente' => 'nullable|integer|exists:clientes,id',
            'data_criacao_inicial' => 'nullable|date_format:d/m/Y|before_or_equal:data_criacao_final',
            'data_criacao_final' => 'nullable|date_format:d/m/Y|after_or_equal:data_criacao_inicial',
            'status' => ['nullable', Rule::in(array_keys(Pedidos::STATUS_PEDIDOS))]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id_cliente.integer' => 'O id_cliente informado é inválido',
            'id_cliente.exists' => 'Nenhum cliente localizado para o id_cliente informado',
            'data_criacao_inicial.date_format' => 'A data de criação inicial deve ser no formato d/m/Y',
            'data_criacao_inicial.before_or_equal' => 'A data de criação inicial deve ser menor ou igual a data de criação final',
            'data_criacao_final.date_format' => 'A data de criação final deve ser no formato d/m/Y',
            'data_criacao_final.after_or_equal' => 'A data de criação final deve ser maior ou igual a data de criação inicial',
            'status.in' => 'O status informado é inválido'
        ];
    }

    public function response(array $errors)
    {
        return response()->json(['teste'], 400);
    }
}
