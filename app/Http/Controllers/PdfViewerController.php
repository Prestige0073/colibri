<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Module;
use App\Models\ModuleContenu;
use App\Models\FormationInscription;
use Illuminate\Support\Facades\Auth;

class PdfViewerController extends Controller
{
    /**
     * Affiche le visualiseur PDF sécurisé dans une page dédiée
     */
    public function show(Formation $formation, Module $module, ModuleContenu $contenu)
    {
        // Vérifier que l'utilisateur est connecté
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à ce contenu.');
        }

        // Vérifier que le module appartient bien à la formation
        if ($module->formation_id !== $formation->id) {
            abort(404);
        }

        // Vérifier que le contenu appartient bien au module
        if ($contenu->module_id !== $module->id) {
            abort(404);
        }

        // Vérifier que c'est bien un PDF
        if ($contenu->type !== 'pdf') {
            abort(403, 'Ce contenu n\'est pas un document PDF.');
        }

        // Vérifier que l'utilisateur est inscrit et a payé
        $inscription = FormationInscription::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->where('paiement_valide', true)
            ->first();

        if (!$inscription) {
            return redirect()->route('formation.show', $formation)
                ->with('error', 'Vous devez vous inscrire et valider votre paiement pour accéder à ce document.');
        }

        // Charger tous les modules de la formation pour vérifier la progression
        $allModules = $formation->modules()->orderBy('ordre')->get();

        // Vérifier si le module précédent est complété (sauf pour le premier module)
        $moduleIndex = $allModules->search(function($item) use ($module) {
            return $item->id === $module->id;
        });

        if ($moduleIndex > 0) {
            $previousModule = $allModules[$moduleIndex - 1];

            // Vérifier si tous les contenus du module précédent sont complétés
            $previousModuleCompleted = true;
            $previousModuleProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
                ->where('module_id', $previousModule->id)
                ->get()
                ->keyBy('module_contenu_id');

            foreach ($previousModule->contenus as $previousContenu) {
                if (!$previousModuleProgressions->has($previousContenu->id) || !$previousModuleProgressions[$previousContenu->id]->completed) {
                    $previousModuleCompleted = false;
                    break;
                }
            }

            if (!$previousModuleCompleted) {
                return redirect()->route('formation.module.show', [$formation, $previousModule])
                    ->with('error', 'Vous devez d\'abord terminer le module précédent avant d\'accéder à celui-ci.');
            }
        }

        // Vérifier si les contenus précédents de ce module sont complétés
        $allContenus = $module->contenus()->orderBy('ordre')->get();
        $contenuIndex = $allContenus->search(function($item) use ($contenu) {
            return $item->id === $contenu->id;
        });

        if ($contenuIndex > 0) {
            $userProgressions = \App\Models\UserModuleProgression::where('user_id', $user->id)
                ->where('module_id', $module->id)
                ->get()
                ->keyBy('module_contenu_id');

            for ($i = 0; $i < $contenuIndex; $i++) {
                $previousContenu = $allContenus[$i];
                if (!$userProgressions->has($previousContenu->id) || !$userProgressions[$previousContenu->id]->completed) {
                    return redirect()->route('formation.module.show', [$formation, $module])
                        ->with('error', 'Vous devez compléter les contenus précédents dans l\'ordre avant d\'accéder à ce document.');
                }
            }
        }

        // Tout est OK, afficher le visualiseur PDF
        return view('pdf.viewer', [
            'formation' => $formation,
            'module' => $module,
            'contenu' => $contenu,
            'user' => $user,
        ]);
    }
}
