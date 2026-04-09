<?php

namespace App\Observers;

use App\Models\Mensagem;
use App\Models\MensagemNaoLida;

class MensagemObserver
{
    public function created(Mensagem $mensagem)
    {
        // Não contar a própria mensagem do user
        if ($mensagem->user_id === auth()->id()) {
            return;
        }

        // Determinar quem deve receber a notificação
        if ($mensagem->conversavel_type === 'App\Models\User') {
            // Mensagem direta: o destinatário é o conversavel_id
            $destinatarioId = $mensagem->conversavel_id;
        } else {
            // Mensagem em sala: todos os participantes menos o remetente
            $sala = $mensagem->conversavel;
            $participantes = $sala->utilizadores()->where('user_id', '!=', $mensagem->user_id)->get();

            foreach ($participantes as $participante) {
                $naoLida = MensagemNaoLida::firstOrNew([
                    'user_id' => $participante->id,
                    'conversavel_id' => $mensagem->conversavel_id,
                    'conversavel_type' => $mensagem->conversavel_type
                ]);
                $naoLida->quantidade++;
                $naoLida->save();
            }
            return;
        }

        // Para mensagem direta
        $naoLida = MensagemNaoLida::firstOrNew([
            'user_id' => $destinatarioId,
            'conversavel_id' => $mensagem->conversavel_id,
            'conversavel_type' => $mensagem->conversavel_type
        ]);
        $naoLida->quantidade++;
        $naoLida->save();
    }
}
