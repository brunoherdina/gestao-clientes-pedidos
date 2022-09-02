<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Rules\Cep;
use App\Rules\Cpf;
use App\Rules\Telefone;
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
            return response()->json(['error' => ['Ocorreu um erro inesperado ao listar os clientes']], 500);
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
                'nome' => 'required|string|max:255',
                'cpf' => new Cpf(),
                'logradouro' => 'required|string|max:255',
                'cidade' => 'required|string|max:255',
                'uf' => 'required|string|max:255',
                'cep' => new Cep(),
                'numero' => 'required|integer',
                'complemento' => 'nullable|string|max:255',
                'telefone' => new Telefone()
            ];

            $mensagens_validacao = [
                'nome.required' => 'O nome é obrigatório',
                'nome.string' => 'O nome deve ser um texto',
                'nome.max' => 'O nome deve conter no máximo 255 caracteres',
                'logradouro.required' => 'O logradouro é obrigatório',
                'logradouro.string' => 'O logradouro deve ser um texto',
                'logradouro.max' => 'O logradouro deve conter no máximo 255 caracteres',
                'cidade.required' => 'A cidade é obrigatória',
                'cidade.string' => 'A cidade deve ser um texto',
                'cidade.max' => 'A cidade deve conter no máximo 255 caracteres',
                'uf.required' => 'A UF é obrigatória',
                'uf.string' => 'A UF deve ser um texto',
                'uf.max' => 'A UF deve conter no máximo 2 caracteres',
                'numero.required' => 'O número é obrigatório',
                'numero.integer' => 'O número deve ser preenchido com um valor numérico',
                'complemento.string' => 'O complemento deve ser um texto',
                'complemento.max' => 'O complemento deve conter no máximo 255 caracteres',
            ];

            $validator = Validator::make($request_array, $campos_validacao, $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            $request_array['cpf'] = preg_replace( '/[^0-9]/is', '', $request_array['cpf'] );
            $request_array['cep'] = preg_replace( '/[^0-9]/is', '', $request_array['cep'] );
            $request_array['telefone'] = preg_replace( '/[^0-9]/is', '', $request_array['telefone'] );

            $cliente = (new Clientes())->fill($request_array);
            $cliente->save();

            return response()->json(['message' => 'Cliente criado com sucesso', 'id' => $cliente->id], 201);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao cadastrar o cliente']], 500);
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
            return response()->json(['error' => ['Ocorreu um erro inesperado ao buscar o cliente']], 500);
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
                'id' => 'required|integer|exists:clientes,id',
                'nome' => 'required|string|max:255',
                'cpf' => new Cpf(),
                'logradouro' => 'required|string|max:255',
                'cidade' => 'required|string|max:255',
                'uf' => 'required|string|max:255',
                'cep' => new Cep(),
                'numero' => 'required|integer',
                'complemento' => 'nullable|string|max:255',
                'telefone' => new Telefone()
            ];

            $mensagens_validacao = [
                'id.required' => 'O ID do cliente é obrigatório',
                'id.integer' => 'O ID informado é inválido',
                'id.exists' => 'Cliente não localizado',
                'nome.required' => 'O nome é obrigatório',
                'nome.string' => 'O nome deve ser um texto',
                'nome.max' => 'O nome deve conter no máximo 255 caracteres',
                'logradouro.required' => 'O logradouro é obrigatório',
                'logradouro.string' => 'O logradouro deve ser um texto',
                'logradouro.max' => 'O logradouro deve conter no máximo 255 caracteres',
                'cidade.required' => 'A cidade é obrigatória',
                'cidade.string' => 'A cidade deve ser um texto',
                'cidade.max' => 'A cidade deve conter no máximo 255 caracteres',
                'uf.required' => 'A UF é obrigatória',
                'uf.string' => 'A UF deve ser um texto',
                'uf.max' => 'A UF deve conter no máximo 2 caracteres',
                'numero.required' => 'O número é obrigatório',
                'numero.integer' => 'O número deve ser preenchido com um valor numérico',
                'complemento.string' => 'O complemento deve ser um texto',
                'complemento.max' => 'O complemento deve conter no máximo 255 caracteres',
            ];

            $validator = Validator::make($request_array, $campos_validacao, $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            unset($request_array['id']);

            $request_array['cpf'] = preg_replace( '/[^0-9]/is', '', $request_array['cpf'] );
            $request_array['cep'] = preg_replace( '/[^0-9]/is', '', $request_array['cep'] );
            $request_array['telefone'] = preg_replace( '/[^0-9]/is', '', $request_array['telefone'] );

            $cliente = Clientes::find($id);
            $cliente->fill($request_array);
            $cliente->save();

            return response()->json(['message' => 'Cliente atualizado com sucesso']);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao cadastrar o cliente']], 500);
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
        try {
            $mensagens_validacao = [
                'id.required' => 'O ID do cliente é obrigatório',
                'id.integer' => 'O ID informado é inválido'
            ];
            $validator = Validator::make(['id' => $id], ['id' => 'required|integer'], $mensagens_validacao);
    
            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            $cliente = Clientes::find($id);
            if($cliente) {
                $cliente->delete();
                return response()->json(['message' => 'Cliente excluído com sucesso']);
            }

            return response()->json(['message' => 'Cliente não existe ou já foi excluído']);

        } catch (\Exception $ex) {
            return response()->json(['error' => ['Ocorreu um erro inesperado ao buscar o cliente']], 500);
        }
    }
}
