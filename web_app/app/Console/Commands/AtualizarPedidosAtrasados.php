<?php

namespace App\Console\Commands;

use App\Models\Pedidos;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AtualizarPedidosAtrasados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AtualizarPedidosAtrasados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza todos os pedidos com a data prevista de entrega maior que hoje e que não estão entregues para ATRASADO';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::debug('Atualizando pedidos atrasados...');
        $data_atual = Carbon::now()->format('Y-m-d');
        Pedidos::where('status', Pedidos::PENDENTE)
                    ->whereNotNull('data_entrega_prevista')
                    ->where('data_entrega_prevista', '<', $data_atual)
                    ->update(['status' => Pedidos::EM_ATRASO]);
    }
}
