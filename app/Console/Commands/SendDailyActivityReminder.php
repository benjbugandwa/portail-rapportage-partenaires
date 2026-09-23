<?php

namespace App\Console\Commands;

use App\Mail\DailyActivityReminderMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDailyActivityReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-activity-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un e-mail de rappel quotidien de rapportage d\'activités à tous les utilisateurs actifs.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Début de l\'envoi des rappels quotidiens d\'activités...');

        $activeUsers = User::where('is_active', true)
            ->whereNotNull('email')
            ->get();

        $count = 0;
        foreach ($activeUsers as $user) {
            try {
                Mail::to($user->email)->send(new DailyActivityReminderMail($user));
                $count++;
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'e-mail de rappel à ' . $user->email . ' : ' . $e->getMessage());
                $this->error('Échec pour ' . $user->email . ' : ' . $e->getMessage());
            }
        }

        Log::info("Rappels quotidiens d'activités envoyés à {$count} utilisateur(s) actif(s).");
        $this->info("Rappels envoyés avec succès à {$count} utilisateur(s) actif(s).");

        return Command::SUCCESS;
    }
}
