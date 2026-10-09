<?php

namespace App\Console\Commands;

use App\Enums\IdeaStatus;
use App\Mail\IdeaMail;
use App\Models\Idea;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckIdeaStartDates extends Command
{
    protected $signature = 'ideas:check-start-dates';
    protected $description = 'Verifica ideias com start_date pronta para envio de e-mail';

    public function handle(): void
    {
        $now = now();

        // Busca ideias com status 'pending' ou 'in_progress', com start_date <= agora e que ainda não enviaram e-mail
        $ideas = Idea::whereIn('status', [IdeaStatus::PENDING, IdeaStatus::IN_PROGRESS])
            ->whereNotNull('start_date')
            ->where('start_date', '<=', $now)
            ->whereNull('email_sent_at')
            ->with('user')
            ->get();

        foreach ($ideas as $idea) {
            // Define para quem será enviado o e-mail (ex: o usuário dono da ideia)
            $recipient = $idea->user->email ?? 'teste@exemplo.com';

            // Marca que o e-mail foi enviado para evitar envios duplicados nas próximas rodadas
            $idea->update([
                'email_sent_at' => $now,
                'end_date' => $now,
                'status'        => IdeaStatus::COMPLETED,
            ]);

            // Dispara o e-mail jogando para a fila
            Mail::to($recipient)->send(new IdeaMail($idea));
        }
    }
}