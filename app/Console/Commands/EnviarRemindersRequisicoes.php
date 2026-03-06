<?php

namespace App\Console\Commands;

use App\Mail\RequisicaoCriadaMail;
use App\Models\Requisicao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarRemindersRequisicoes extends Command
{
    protected $signature = 'requisicoes:reminders';
    protected $description = 'Envia reminder 1 dia antes do fim previsto';

    public function handle()
    {
        $amanha = now()->addDay()->toDateString();

        $requisicoes = Requisicao::with(['user','livro'])
            ->whereIn('status', ['pendente','ativa','por_confirmar'])
            ->whereDate('fim_previsto', $amanha)
            ->whereNull('reminder_enviado_em')
            ->get();

        foreach ($requisicoes as $r) {
            Mail::to($r->user->email)->send(new RequisicaoCriadaMail($r));
            $r->reminder_enviado_em = now();
            $r->save();
        }

        $this->info("Reminders enviados: " . $requisicoes->count());
        return self::SUCCESS;
    }
}
