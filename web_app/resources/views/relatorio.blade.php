<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Relatório pedidos</title>

        {{-- CSS --}}

        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        {{-- Datepicker --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- Estilo da página --}}
        <link href="{{asset('css/relatorio.css')}}" rel="stylesheet">
        {{-- Toast --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- JAVASCRIPT --}}

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        {{-- Jquery --}}
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        {{-- Datepicker --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- Toast --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    </head>
    <body class="antialiased">

        <div class="row linha-logo">
            <div class="col-12 d-flex justify-content-start align-items-center">
                <img src="{{asset('/img/logo.png')}}" class="brudam-logo" alt="Brudam Logo">
                <span class="nome_empresa">Brudam</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Relatório de pedidos</h2>
            </div>
            <div class="card-body">

                {{-- Filtros --}}

                <div class="row">
                    <div class="col-2">
                        <label for="id_cliente">Cliente</label>
                        <select name="id_cliente" class="form-control form-control-lg" id="id_cliente">
                            <option value="">Selecione</option>
                            @foreach($clientes as $id => $nome)
                                <option value="{{$id}}">{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="status">Status</label>
                        <select name="status" class="form-control form-control-lg" id="status">
                            <option value="">Selecione</option>
                            @foreach($status as $id => $nome)
                                <option value="{{$id}}">{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="data_criacao_inicial">Data criação inicial</label>
                        <input type="text" class="form-control form-control-lg datepicker" id="data_criacao_inicial" name="data_criacao_inicial" autocomplete="off">
                    </div>
                    <div class="col-2">
                        <label for="data_criacao_final">Data criação final</label>
                        <input type="text" class="form-control form-control-lg datepicker" id="data_criacao_final" name="data_criacao_final" autocomplete="off">
                    </div>
                    <div class="col-4 d-flex align-items-end">
                        <button class="btn btn-success botoes pesquisar" type="button">Pesquisar</button>
                        <button class="btn btn-danger botoes limpar_filtro" type="button">Limpar filtros</button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="links_paginacao col-12">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
        
                        <div class="table-responsive overflow-auto" id="pedidos_marketplace">
                            <table class="table tablePedidos">
                                <thead>
                                    <tr>
                                        <th class="table_head">ID</th>
                                        <th class="table_head">Cliente</th>
                                        <th class="table_head">Status</th>
                                        <th class="table_head">Previsão de entrega</th>
                                        <th class="table_head">Data entrega</th>
                                        <th class="table_head">Valor frete</th>
                                        <th class="table_head">Data pedido</th>
                                    </tr>
                                </thead>
                                <tbody id="table_pedidos_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="links_paginacao">
                </div>
            </div>
        </div>


    </body>

    <script>

    const buscarDados = (pagina) => {

        if(!pagina) {
            pagina = 1;
        }
        let url = "/buscar_dados?page=" + pagina;

        $.ajax({
            type: "GET",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "id_cliente" : $("#id_cliente").val(),
                "status" : $("#status").val(),
                "data_criacao_inicial" : $("#data_criacao_inicial").val(),
                "data_criacao_final" : $("#data_criacao_final").val()
            },
            dataType: 'json',
            success: function(data) {
                $('#table_pedidos_body').html(data.html_tabela);
                $('.links_paginacao').html(data.links_paginacao);

                $('.links_tabela a').click((e) => {
                    e.preventDefault();
                    let url = $(e.target).attr('href');
                    let pagina = url.split("page=")[1];
                    buscarDados(parseInt(pagina));
                });
            },
            error: function(response) {
                if (response.status == 422) {
                   var errors = Object.entries(JSON.parse(response.responseText));
                    errors.forEach(campo => {
                        if(campo[0] == 'errors') {
                            let mensagens = Object.entries(campo[1]);
                            mensagens.forEach(mensagem => {
                                toastr.error(mensagem[1]);
                            });
                        }
                    });
               }
            }
        });
    }

        $(document).ready(() => {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
            });

            $('.limpar_filtro').on('click', () => {
                $('#id_cliente').val("");
                $('#status').val("");
                $('#data_criacao_inicial').val("");
                $('#data_criacao_final').val("");
            });

            $('.pesquisar').on('click', () => {
                buscarDados();
            });

            buscarDados();
        });

    </script>
</html>
