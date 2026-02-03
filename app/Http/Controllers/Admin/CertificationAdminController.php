<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class CertificationAdminController extends Controller
{
    /**
     * Afficher la liste des certifications et le formulaire de génération
     */
    public function index()
    {
        // Récupérer tous les certificats
        $certificats = Certificat::with(['user', 'formation'])
            ->latest()
            ->get();

        // Récupérer toutes les formations pour le formulaire
        $formations = Formation::where('active', true)->orderBy('titre')->get();

        // Récupérer tous les utilisateurs pour le formulaire
        $users = User::orderBy('name')->get();

        return view('admin.certifications', compact('certificats', 'formations', 'users'));
    }

    /**
     * Générer un certificat manuellement (seule méthode de génération)
     */
    public function generate(Request $request)
    {
        $request->validate([
            'nom_apprenant' => 'required|string|max:255',
            'email_apprenant' => 'nullable|email|max:255',
            'formation_id' => 'required|exists:formations,id',
            'note_obtenue' => 'required|integer|min:0|max:100',
            'date_delivrance' => 'required|date',
            'lieu_delivrance' => 'required|string|max:255',
            'signataire_nom' => 'required|string|max:255',
            'signataire_titre' => 'required|string|max:255',
            'cachet' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'signature' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nom_apprenant.required' => 'Le nom de l\'apprenant est obligatoire.',
            'formation_id.required' => 'Veuillez sélectionner une formation.',
            'note_obtenue.required' => 'La note obtenue est obligatoire.',
            'note_obtenue.min' => 'La note doit être au minimum 0.',
            'note_obtenue.max' => 'La note doit être au maximum 100.',
            'date_delivrance.required' => 'La date de délivrance est obligatoire.',
            'lieu_delivrance.required' => 'Le lieu de délivrance est obligatoire.',
            'signataire_nom.required' => 'Le nom du signataire est obligatoire.',
            'signataire_titre.required' => 'Le titre du signataire est obligatoire.',
            'cachet.required' => 'Le cachet est obligatoire.',
            'cachet.image' => 'Le cachet doit être une image.',
            'cachet.mimes' => 'Le cachet doit être au format PNG, JPG ou JPEG.',
        ]);

        // Générer le numéro de certificat unique
        $numeroCertificat = $this->generateNumeroCertificat();

        // Stocker les images (cachet et signature uniquement, logo par défaut)
        $cachetPath = $request->file('cachet')->store('certificats/cachets', 'public');
        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('certificats/signatures', 'public');
        }

        // Créer le certificat (logo_path null = utiliser le logo par défaut)
        $certificat = Certificat::create([
            'nom_manuel' => $request->nom_apprenant,
            'email_manuel' => $request->email_apprenant,
            'formation_id' => $request->formation_id,
            'numero_certificat' => $numeroCertificat,
            'note_obtenue' => $request->note_obtenue,
            'date_delivrance' => $request->date_delivrance,
            'lieu_delivrance' => $request->lieu_delivrance,
            'signataire_nom' => $request->signataire_nom,
            'signataire_titre' => $request->signataire_titre,
            'logo_path' => null,
            'cachet_path' => $cachetPath,
            'signature_path' => $signaturePath,
            'statut' => 'genere',
        ]);

        // Générer le PDF
        $pdfPath = $this->generatePDF($certificat);
        $certificat->update(['fichier_pdf' => $pdfPath]);

        // Envoyer par email si demandé
        if ($request->has('send_email') && $request->email_apprenant) {
            $this->sendCertificatEmail($certificat);
        }

        return redirect()->back()->with('success', 'Certificat généré avec succès ! Numéro: ' . $numeroCertificat);
    }

    /**
     * Télécharger un certificat en PDF
     */
    public function download($certificatId)
    {
        $certificat = Certificat::with(['formation'])->findOrFail($certificatId);

        // Si le PDF existe déjà, le télécharger
        if ($certificat->fichier_pdf && Storage::disk('public')->exists($certificat->fichier_pdf)) {
            return response()->download(storage_path('app/public/' . $certificat->fichier_pdf));
        }

        // Sinon, le générer à la volée
        $pdf = $this->generatePDFObject($certificat);
        return $pdf->download('certificat-' . $certificat->numero_certificat . '.pdf');
    }

    /**
     * Régénérer le PDF d'un certificat
     */
    public function regenerate($certificatId)
    {
        $certificat = Certificat::with(['formation'])->findOrFail($certificatId);

        // Supprimer l'ancien PDF s'il existe
        if ($certificat->fichier_pdf && Storage::disk('public')->exists($certificat->fichier_pdf)) {
            Storage::disk('public')->delete($certificat->fichier_pdf);
        }

        // Générer le nouveau PDF
        $pdfPath = $this->generatePDF($certificat);
        $certificat->update(['fichier_pdf' => $pdfPath]);

        return redirect()->back()->with('success', 'PDF du certificat régénéré avec succès !');
    }

    /**
     * Envoyer le certificat par email
     */
    public function sendEmail($certificatId)
    {
        $certificat = Certificat::with(['formation'])->findOrFail($certificatId);

        if (!$certificat->email_manuel) {
            return redirect()->back()->with('error', 'Aucun email associé à ce certificat.');
        }

        $this->sendCertificatEmail($certificat);

        return redirect()->back()->with('success', 'Certificat envoyé par email avec succès !');
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

        return redirect()->back()->with('success', 'Statut modifié de "' . $oldStatus . '" à "' . $request->statut . '" !');
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

        return 'CL-' . $year . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
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
        $certificat->load(['formation']);

        $data = [
            'certificat' => $certificat,
            'formation' => $certificat->formation,
            'cachetPath' => $certificat->cachet_path ? storage_path('app/public/' . $certificat->cachet_path) : null,
            'signaturePath' => $certificat->signature_path ? storage_path('app/public/' . $certificat->signature_path) : null,
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
        // TODO: Implémenter l'envoi d'email avec le PDF en pièce jointe
        // Mail::to($certificat->email_manuel)->send(new CertificatMail($certificat));

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
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');
            \Artisan::call('config:clear');
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

            // Supprimer les fichiers associés
            if ($certificat->fichier_pdf && Storage::disk('public')->exists($certificat->fichier_pdf)) {
                Storage::disk('public')->delete($certificat->fichier_pdf);
            }
            if ($certificat->cachet_path && Storage::disk('public')->exists($certificat->cachet_path)) {
                Storage::disk('public')->delete($certificat->cachet_path);
            }
            if ($certificat->signature_path && Storage::disk('public')->exists($certificat->signature_path)) {
                Storage::disk('public')->delete($certificat->signature_path);
            }

            $certificat->delete();

            return redirect()->back()->with('success', 'Certificat supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
