<?php

namespace App\Console\Commands;

use App\Models\Commande;
use Illuminate\Console\Command;

class FixPaidOrdersStatus extends Command
{
    protected $signature = 'orders:fix-paid-status';

    protected $description = 'Corrige le statut des commandes payées en ligne vers "paid"';

    public function handle()
    {
        $this->info('Recherche des commandes avec anomalie de statut...');

        // Achats en ligne payés mais avec un statut autre que 'paid'
        $anomalies = Commande::where('paiement_valide', true)
            ->whereNotNull('payment_method')
            ->where('payment_method', '!=', 'livraison')
            ->where('statut', '!=', Commande::STATUT_PAID)
            ->get();

        if ($anomalies->isEmpty()) {
            $this->info('Aucune commande avec anomalie trouvee.');
            return 0;
        }

        $this->warn("{$anomalies->count()} commande(s) payee(s) avec statut incorrect.");

        foreach ($anomalies as $cmd) {
            $old = $cmd->statut;
            $cmd->statut = Commande::STATUT_PAID;
            $cmd->save();
            $this->line("  Commande #{$cmd->id}: '{$old}' -> 'paid'");
        }

        $this->info("{$anomalies->count()} commande(s) corrigee(s).");

        return 0;
    }
}
