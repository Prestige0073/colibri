<?php

namespace App\Console\Commands;

use App\Models\Commande;
use Illuminate\Console\Command;

class FixPaidOrdersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:fix-paid-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige le statut des commandes payées mais encore en "pending"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Recherche des commandes avec anomalie de statut...');
        
        $commandesAnomalies = Commande::where('paiement_valide', true)
            ->where('statut', 'pending')
            ->get();

        if ($commandesAnomalies->isEmpty()) {
            $this->info('✅ Aucune commande avec anomalie trouvée.');
            return 0;
        }

        $this->warn("⚠️  {$commandesAnomalies->count()} commande(s) payée(s) avec statut 'pending' trouvée(s).");
        
        if (!$this->confirm('Voulez-vous corriger ces commandes ?', true)) {
            $this->info('Opération annulée.');
            return 0;
        }

        $bar = $this->output->createProgressBar($commandesAnomalies->count());
        $bar->start();

        foreach ($commandesAnomalies as $cmd) {
            $cmd->statut = Commande::STATUT_CONFIRMED;
            $cmd->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ {$commandesAnomalies->count()} commande(s) corrigée(s) avec succès!");

        return 0;
    }
}
