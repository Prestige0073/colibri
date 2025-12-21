<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmpruntService;

class UpdateExpiredEmprunts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emprunts:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour automatiquement le statut des emprunts dont la date de retour est dépassée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des emprunts expirés...');

        // Marquer d'abord les emprunts en retard
        $lateCount = EmpruntService::markLateEmprunts();
        if ($lateCount > 0) {
            $this->line("⚠ {$lateCount} emprunt(s) marqué(s) en retard.");
        }

        // Puis mettre à jour les emprunts expirés en "retourné"
        $expiredCount = EmpruntService::updateExpiredEmprunts();

        if ($expiredCount === 0) {
            $this->info('Aucun emprunt expiré trouvé.');
            return Command::SUCCESS;
        }

        $this->info("✓ {$expiredCount} emprunt(s) mis à jour avec succès (statut: retourné).");
        return Command::SUCCESS;
    }
}
