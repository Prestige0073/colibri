<?php

namespace App\Services;

use App\Models\Emprunt;
use Carbon\Carbon;

class EmpruntService
{
    /**
     * Met à jour automatiquement le statut des emprunts expirés
     *
     * @return int Nombre d'emprunts mis à jour
     */
    public static function updateExpiredEmprunts(): int
    {
        // Récupérer tous les emprunts en cours ou en retard dont la date de retour est dépassée
        $empruntsExpires = Emprunt::with('livre')
            ->whereIn('statut', ['en_cours', 'en_retard'])
            ->where('date_retour', '<', Carbon::now())
            ->get();

        if ($empruntsExpires->isEmpty()) {
            return 0;
        }

        $count = 0;
        foreach ($empruntsExpires as $emprunt) {
            // Mettre à jour le statut à "retourné"
            $emprunt->update([
                'statut' => 'retourne'
            ]);

            // Restaurer le stock du livre
            if ($emprunt->livre) {
                $emprunt->livre->increment('quantite');
            }

            $count++;
        }

        return $count;
    }

    /**
     * Marque les emprunts en retard (date de retour dépassée mais pas encore retournés)
     *
     * @return int Nombre d'emprunts marqués en retard
     */
    public static function markLateEmprunts(): int
    {
        $empruntsEnCours = Emprunt::where('statut', 'en_cours')
            ->where('date_retour', '<', Carbon::now())
            ->get();

        $count = 0;
        foreach ($empruntsEnCours as $emprunt) {
            $emprunt->update([
                'statut' => 'en_retard'
            ]);
            $count++;
        }

        return $count;
    }
}
