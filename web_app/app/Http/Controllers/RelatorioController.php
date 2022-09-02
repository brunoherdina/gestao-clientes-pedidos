<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\PedidosController;
use App\Http\Requests\ListagemPedidosRequest;
use App\Models\Clientes;
use App\Models\Pedidos;

class RelatorioController extends Controller
{
   public function index()
   {
       try {
            $clientes = Clientes::orderBy('nome')->pluck('nome', 'id')->toArray();
            $status = Pedidos::STATUS_PEDIDOS;

            return view('relatorio', [
                'clientes' => $clientes,
                'status' => $status
            ]);

       } catch (\Exception $ex) {
            dd('Ocorreu um erro ao buscar os dados do relatório');
       }
   }

   public function buscarDados(ListagemPedidosRequest $request)
   {
       $pedidos = (new PedidosController())->buscarDadosPedidos($request);

       $html_tabela = "";

       foreach($pedidos as $p) {
           $id = $p->id;
           $nome_cliente = $p->cliente->nome;
           $status = $p->status_descricao;
           $data_previsao_entrega = $p->data_entrega_prevista_formatada;
           $data_entrega = $p->data_entrega_formatada;
           $valor_frete = $p->valor_frete ?? 0;
           $valor_frete = number_format($valor_frete,2,",",".");
           $data_criacao = $p->data_criacao_formatada;

           $html_tabela .= "<tr>";
           $html_tabela .= "<td class='text-center'>$id</td>";
           $html_tabela .= "<td class='text-center'>$nome_cliente</td>";
           $html_tabela .= "<td class='text-center'>$status</td>";
           $html_tabela .= "<td class='text-center'>$data_previsao_entrega</td>";
           $html_tabela .= "<td class='text-center'>$data_entrega</td>";
           $html_tabela .= "<td class='text-center'>$valor_frete</td>";
           $html_tabela .= "<td class='text-center'>$data_criacao</td>";
           $html_tabela .= "<tr>";
       }

       $links_paginacao = "";

       if($html_tabela) {
           $links_paginacao =  '<div class="d-inline-block links_tabela">
           ' . $pedidos->links('pagination::bootstrap-4') . '
           </div>';
       }

       return response()->json(['html_tabela' => $html_tabela, 'links_paginacao' => $links_paginacao]);
   }
}
