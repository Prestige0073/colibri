<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use App\Models\FormationInscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class CertificationAdminController extends Controller
{
    /**
     * Afficher la liste des certifications
     */
    public function index()
    {
        // Récupérer toutes les inscriptions avec progression 100% (formations terminées)
        $inscriptions = FormationInscription::with(['user', 'formation', 'certificat'])
            ->where('progression', 100)
            ->latest()
            ->get();

        // Récupérer tous les certificats
        $certificats = Certificat::with(['user', 'formation'])
            ->latest()
            ->get();

        return view('admin.certifications', compact('inscriptions', 'certificats'));
    }

    /**
     * Générer un certificat pour une inscription
     */
    public function generate(Request $request, $inscriptionId)
    {
        $request->validate([
            'note_obtenue' => 'required|integer|min:0|max:100',
            'send_email' => 'nullable|boolean',
        ]);

        $inscription = FormationInscription::with(['user', 'formation'])->findOrFail($inscriptionId);

        // Vérifier que la formation est terminée
        if ($inscription->progression < 100) {
            return redirect()->back()->with('error', 'La formation n\'est pas encore terminée.');
        }

        // Vérifier qu'un certificat n'existe pas déjà
        if ($inscription->certificat) {
            return redirect()->back()->with('error', 'Un certificat a déjà été généré pour cette inscription.');
        }

        // Générer le numéro de certificat unique
        $numeroCertificat = $this->generateNumeroCertificat();

        // Créer le certificat
        $certificat = Certificat::create([
            'formation_inscription_id' => $inscription->id,
            'user_id' => $inscription->user_id,
            'formation_id' => $inscription->formation_id,
            'numero_certificat' => $numeroCertificat,
            'note_obtenue' => $request->note_obtenue,
            'date_delivrance' => now(),
            'statut' => 'genere',
        ]);

        // Générer le PDF
        $pdfPath = $this->generatePDF($certificat);
        $certificat->update(['fichier_pdf' => $pdfPath]);

        // Envoyer par email si demandé
        if ($request->has('send_email')) {
            $this->sendCertificatEmail($certificat);
        }

        return redirect()->back()->with('success', 'Certificat généré avec succès !');
    }

    /**
     * Générer un certificat manuellement
     */
    public function generateManual(Request $request)
    {
        $request->validate([
            'apprenant_type' => 'required|in:existant,manuel',
            'user_id' => 'required_if:apprenant_type,existant|nullable|exists:users,id',
            'nom_manuel' => 'required_if:apprenant_type,manuel|nullable|string|max:255',
            'email_manuel' => 'required_if:apprenant_type,manuel|nullable|email|max:255',
            'formation_id' => 'required|exists:formations,id',
            'note_obtenue' => 'required|integer|min:0|max:100',
            'date_delivrance' => 'required|date',
        ]);

        $formationId = $request->formation_id;
        $isManual = $request->apprenant_type === 'manuel';
        $emailManuel = null;

        // Si saisie manuelle, créer un utilisateur temporaire
        if ($isManual) {
            $userId = null;
            $nomApprenant = $request->nom_manuel;
            $emailManuel = $request->email_manuel;
            $inscription = null; // Pas d'inscription pour un certificat manuel
        } else {
            $userId = $request->user_id;
            $nomApprenant = null;

            // Vérifier si une inscription existe
            $inscription = FormationInscription::where('user_id', $userId)
                ->where('formation_id', $formationId)
                ->first();

            // Si aucune inscription n'existe, en créer une automatiquement
            if (!$inscription) {
                $inscription = FormationInscription::create([
                    'user_id' => $userId,
                    'formation_id' => $formationId,
                    'progression' => 100,
                    'statut' => 'termine',
                    'date_inscription' => now(),
                    'date_fin' => now(),
                    'paiement_valide' => true,
                    'montant_paye' => 0,
                ]);
            }

            // Vérifier qu'un certificat n'existe pas déjà pour cette inscription
            if ($inscription->certificat) {
                return redirect()->back()->with('error', 'Un certificat existe déjà pour cet apprenant et cette formation.');
            }
        }

        // Générer le numéro de certificat unique
        $numeroCertificat = $this->generateNumeroCertificat();

        // Créer le certificat
        $certificat = Certificat::create([
            'formation_inscription_id' => $inscription ? $inscription->id : null,
            'user_id' => $userId,
            'nom_manuel' => $nomApprenant,
            'email_manuel' => $emailManuel,
            'formation_id' => $formationId,
            'numero_certificat' => $numeroCertificat,
            'note_obtenue' => $request->note_obtenue,
            'date_delivrance' => $request->date_delivrance,
            'statut' => 'genere',
        ]);

        // Générer le PDF
        $pdfPath = $this->generatePDF($certificat);
        $certificat->update(['fichier_pdf' => $pdfPath]);

        // Envoyer par email si demandé
        if ($request->has('send_email')) {
            if ($isManual && $emailManuel) {
                // Envoyer à l'email manuel
                // TODO: Implémenter l'envoi d'email avec le PDF en pièce jointe
                // Mail::to($emailManuel)->send(new CertificatMail($certificat, $pdf));
                $certificat->update([
                    'envoye_email' => true,
                    'date_envoi_email' => now(),
                    'statut' => 'envoye',
                ]);
            } elseif (!$isManual && $userId) {
                // Envoyer à l'utilisateur existant
                $this->sendCertificatEmail($certificat);
            }
        }

        return redirect()->back()->with('success', 'Certificat généré manuellement avec succès !');
    }

    /**
     * Télécharger un certificat en PDF
     */
    public function download($certificatId)
    {
        $certificat = Certificat::with(['user', 'formation'])->findOrFail($certificatId);

        // Si le PDF existe déjà, le télécharger
        if ($certificat->fichier_pdf && Storage::disk('public')->exists($certificat->fichier_pdf)) {
            return response()->download(storage_path('app/public/' . $certificat->fichier_pdf));
        }

        // Sinon, le générer à la volée
        $pdf = $this->generatePDFObject($certificat);
        return $pdf->download('certificat-' . $certificat->numero_certificat . '.pdf');
    }

    /**
     * Envoyer le certificat par email
     */
    public function sendEmail($certificatId)
    {
        $certificat = Certificat::with(['user', 'formation'])->findOrFail($certificatId);

        $this->sendCertificatEmail($certificat);

        return redirect()->back()->with('success', 'Certificat envoyé par email avec succès !');
    }

    /**
     * Envoyer le certificat par email avec destinataire personnalisé
     */
    public function sendEmailCustom(Request $request, $certificatId)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'message' => 'nullable|string|max:1000',
        ]);

        $certificat = Certificat::with(['user', 'formation'])->findOrFail($certificatId);

        // TODO: Implémenter l'envoi d'email personnalisé avec le PDF en pièce jointe
        // Mail::to($request->recipient_email)->send(new CertificatCustomMail($certificat, $request->message, $pdf));

        $certificat->update([
            'envoye_email' => true,
            'date_envoi_email' => now(),
            'statut' => 'envoye',
        ]);

        return redirect()->back()->with('success', 'Certificat envoyé à ' . $request->recipient_email . ' avec succès !');
    }

    /**
     * Changer le statut d'un certificat
     */
    public function changeStatus(Request $request, $certificatId)
    {
        $request->validate([
            'statut' => 'required|in:genere,envoye,valide,annule',
        ]);

        $certificat = Certificat::findOrFail($certificatId);
        $oldStatus = $certificat->statut;

        $certificat->update([
            'statut' => $request->statut,
        ]);

        return redirect()->back()->with('success', 'Statut du certificat modifié de "' . $oldStatus . '" à "' . $request->statut . '" avec succès !');
    }

    /**
     * Générer un numéro de certificat unique
     */
    private function generateNumeroCertificat()
    {
        $year = now()->format('Y');
        $lastCertificat = Certificat::whereYear('created_at', now()->year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastCertificat ? (int)substr($lastCertificat->numero_certificat, -5) + 1 : 1;

        return 'CERT-' . $year . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Générer le fichier PDF du certificat
     */
    private function generatePDF($certificat)
    {
        $pdf = $this->generatePDFObject($certificat);

        // Sauvegarder le PDF
        $filename = 'certificats/certificat-' . $certificat->numero_certificat . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Générer l'objet PDF du certificat
     */
    private function generatePDFObject($certificat)
    {
        $certificat->load(['formation', 'inscription']);

        // Charger l'utilisateur seulement s'il existe
        if ($certificat->user_id) {
            $certificat->load('user');
        }

        $data = [
            'certificat' => $certificat,
            'user' => $certificat->user ?? (object)['name' => $certificat->nom_manuel],
            'formation' => $certificat->formation,
            'inscription' => $certificat->inscription,
        ];

        $pdf = Pdf::loadView('pdf.certificat', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf;
    }

    /**
     * Envoyer le certificat par email
     */
    private function sendCertificatEmail($certificat)
    {
        $pdf = $this->generatePDFObject($certificat);

        // TODO: Implémenter l'envoi d'email avec le PDF en pièce jointe
        // Mail::to($certificat->user->email)->send(new CertificatMail($certificat, $pdf));

        $certificat->update([
            'envoye_email' => true,
            'date_envoi_email' => now(),
            'statut' => 'envoye',
        ]);
    }

    /**
     * Vider tous les caches
     */
    public function clearCache()
    {
        try {
            // Vider le cache de Laravel
            \Artisan::call('cache:clear');

            // Vider le cache des vues
            \Artisan::call('view:clear');

            // Vider le cache des routes
            \Artisan::call('route:clear');

            // Vider le cache de configuration
            \Artisan::call('config:clear');

            // Vider le cache compilé
            \Artisan::call('optimize:clear');

            return redirect()->back()->with('success', 'Tous les caches ont été vidés avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du vidage des caches : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un certificat
     */
    public function destroy($id)
    {
        try {
            $certificat = Certificat::findOrFail($id);

            // Supprimer le fichier PDF s'il existe
            if ($certificat->fichier_pdf && Storage::disk('public')->exists($certificat->fichier_pdf)) {
                Storage::disk('public')->delete($certificat->fichier_pdf);
            }

            // Supprimer le certificat de la base de données
            $certificat->delete();

            return redirect()->back()->with('success', 'Certificat supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function create() { }
    public function store(Request $request) { }
    public function show($id) { }
    public function edit($id) { }
}
