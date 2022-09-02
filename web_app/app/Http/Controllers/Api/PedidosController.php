<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pedidos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $request_array = $request->all();

            $campos_validacao = [
                'id_cliente' => 'nullable|integer|exists:clientes,id',
                'data_criacao_inicial' => 'nullable|date_format:Y-m-d|before_or_equal:data_criacao_final',
                'data_criacao_final' => 'nullable|date_format:Y-m-d|after_or_equal:data_criacao_inicial',
                'status' => ['nullable', Rule::in(array_keys(Pedidos::STATUS_PEDIDOS))]
            ];

            $mensagens_validacao = [
                'id_cliente.integer' => 'O id_cliente informado é inválido',
                'id_cliente.exists' => 'Nenhum cliente localizado para o id_cliente informado',
                'data_criacao_inicial.date_format' => 'O período inicial deve ser no formato Y-m-d',
                'data_criacao_inicial.before_or_equal' => 'O período inicial deve ser menor ou igual ao periodo final',
                'data_criacao_final.date_format' => 'O período final deve ser no formato Y-m-d',
                'data_criacao_final.after_or_equal' => 'O período final deve ser maior ou igual ao periodo inicial',
                'status.in' => 'O status informado é inválido'
            ];

            $validator = Validator::make($request_array, $campos_validacao, $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            $id_cliente = $request_array['id_cliente'] ?? null;
            $data_criacao_inicial = $request_array['data_criacao_inicial'] ?? null;
            $data_criacao_final = $request_array['data_criacao_final'] ?? null;
            $status = $request_array['status'] ?? null;

            $pedidos = Pedidos::with('cliente');

            if($id_cliente) {
                $pedidos->where('id_cliente', $id_cliente);
            }

            if($data_criacao_inicial) {
                $pedidos->whereDate('created_at', '>=', $data_criacao_inicial);
            }

            if($data_criacao_final) {
                $pedidos->whereDate('created_at', '<=', $data_criacao_final);
            }

            if($status) {
                $pedidos->where('status', $status);
            }

            $pedidos = $pedidos->paginate(10, ['*'], 'page');

            return response()->json($pedidos);
        
        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao listar os pedidos']], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request_array = $request->all();

            $campos_validacao = [
                'id_cliente' => 'required|integer|exists:clientes,id',
                'valor_frete' => 'required|numeric',
                'data_entrega_prevista' => 'nullable|date_format:Y-m-d',
                'data_entrega' => 'nullable|date_format:Y-m-d',
            ];

            $mensagens_validacao = [
                'id_cliente.required' => 'O id_cliente é obrigatório',
                'id_cliente.integer' => 'O id_cliente informado é inválido',
                'id_cliente.exists' => 'Nenhum cliente localizado para o id_cliente informado',
                'valor_frete.required' => 'O valor do frete é obrigatório',
                'valor_frete.numeric' => 'O valor do frete deve ser um número',
                'data_entrega_prevista.date_format' => 'A data de entrega prevista deve ser no formato Y-m-d',
                'data_entrega.date_format' => 'A data de entrega deve ser no formato Y-m-d',
            ];

            $validator = Validator::make($request_array, $campos_validacao, $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            $pedido = (new Pedidos())->fill($request_array);
            $pedido->save();

            return response()->json(['message' => 'Pedido criado com sucesso', 'id' => $pedido->id], 201);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao cadastrar o pedido']], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $mensagens_validacao = [
                'id.required' => 'O ID do pedido é obrigatório',
                'id.integer' => 'O ID informado é inválido',
                'id.exists' => 'Pedido não localizado'
            ];
            $validator = Validator::make(['id' => $id], ['id' => 'required|integer|exists:pedidos,id'], $mensagens_validacao);

            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            return response()->json([Pedidos::find($id)]);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao buscar o pedido']], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request_array = $request->all();
            $request_array['id'] = $id;

            $campos_validacao = [
                'id' => 'required|integer|exists:pedidos,id',
                'id_cliente' => 'required|integer|exists:clientes,id',
                'valor_frete' => 'required|numeric',
                'data_entrega_prevista' => 'nullable|date_format:Y-m-d',
                'data_entrega' => 'nullable|date_format:Y-m-d',
                'status' => ['nullable', Rule::in(array_keys(Pedidos::STATUS_PEDIDOS))]
            ];

            $mensagens_validacao = [
                'id.required' => 'O ID do pedido é obrigatório',
                'id.integer' => 'O ID do pedido informado é inválido',
                'id.exists' => 'Nenhum pedido localizado para o ID informado',
                'id_cliente.required' => 'O id_cliente é obrigatório',
                'id_cliente.integer' => 'O id_cliente informado é inválido',
                'id_cliente.exists' => 'Nenhum cliente localizado para o id_cliente informado',
                'valor_frete.required' => 'O valor do frete é obrigatório',
                'valor_frete.numeric' => 'O valor do frete deve ser um número',
                'data_entrega_prevista.date_format' => 'A data de entrega prevista deve ser no formato Y-m-d',
                'data_entrega.date_format' => 'A data de entrega deve ser no formato Y-m-d',
                'status.in' => 'O status informado é inválido'
            ];

            $validator = Validator::make($request_array, $campos_validacao, $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            unset($request_array['id']);
            $novo_status = $request_array['status'] ?? null;
            $pedido = Pedidos::find($id);

            // Caso não seja enviada a data de entrega mas o status tenha mudado de PENDENTE para ENTREGUE define a data de entrega como sendo o dia atual
            if($novo_status == Pedidos::ENTREGUE) {
                $data_entrega = $request_array['data_entrega'] ?? null;
                if($pedido->status == Pedidos::PENDENTE && !$data_entrega) {
                    $data_entrega = Carbon::now()->format('Y-m-d');
                    $request_array['data_entrega'] = $data_entrega;
                }
            }

            $pedido->fill($request_array);
            $pedido->save();

            return response()->json(['message' => 'Pedido atualizado com sucesso'], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao atualizar o pedido']], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }
}
