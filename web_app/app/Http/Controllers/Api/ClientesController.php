<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $nome = $request->get('nome');
            
            $clientes = Clientes::query();
        
            if($nome) {
                $clientes->where('nome', 'like', "%$nome%");
            }
        
            $clientes = $clientes->paginate(10, ['*'], 'page');
            
            return response()->json($clientes);
        
        } catch (\Exception $ex) {
            return response()->json(['erro' => ['Ocorreu um erro inesperado ao listar os clientes']], 500);
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
                'id.required' => 'O ID do cliente é obrigatório',
                'id.integer' => 'O ID informado é inválido',
                'id.exists' => 'Cliente não localizado'
            ];
            $validator = Validator::make(['id' => $id], ['id' => 'required|integer|exists:clientes,id'], $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }
    
            return response()->json([Clientes::find($id)]);
        } catch (\Exception $ex) {
            return response()->json(['erro' => ['Ocorreu um erro inesperado ao buscar o cliente']], 500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
