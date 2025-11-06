<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Routes resource pour l'administration
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\DonationAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\Admin\QuizAdminController;
use App\Http\Controllers\Admin\CertificationAdminController;
use App\Http\Controllers\Admin\CatalogueAdminController;
use App\Http\Controllers\Admin\AchatAdminController;
use App\Http\Controllers\Admin\ModuleAdminController;
use App\Http\Controllers\Admin\TeamAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Admin\EmpruntController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\Admin\FormationController as AdminFormationController;

// Route d'accueil nommée 'index' pour la page principale
Route::get('/', [IndexController::class, 'index'])->name('index');

// Blog
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');

// Routes pour Apprendre
Route::get('formation/modules', [FormationController::class, 'modules'])->name('formation.modules');
Route::get('formation/quiz', [FormationController::class, 'quiz'])->name('formation.quiz');
Route::get('formation/certification', [FormationController::class, 'certification'])->name('formation.certification');
// Route de détail d'une formation
Route::get('formation/{formation}', [FormationController::class, 'show'])->name('formation.show');
Route::post('formation/{formation}/acheter', [FormationController::class, 'acheter'])->name('formation.acheter');
Route::get('formation/{formation}/module/{module}', [FormationController::class, 'moduleShow'])->name('formation.module.show');

// Routes pour Catalogue
Route::get('catalogue/decouvrir', [CatalogueController::class, 'decouvrir'])->name('catalogue.decouvrir');
Route::get('catalogue/acheter', [CatalogueController::class, 'acheter'])->name('catalogue.acheter');
// Route index compatible avec les appels existants
Route::get('catalogue', [CatalogueController::class, 'decouvrir'])->name('catalogue.index');

// Routes resource pour chaque page principale
Route::resource('about', AboutController::class);
Route::resource('contact', ContactController::class);
Route::resource('donation', DonationController::class);
Route::resource('event', EventController::class);
Route::resource('feature', FeatureController::class);
Route::resource('service', ServiceController::class);
Route::resource('team', TeamController::class);
Route::resource('testimonial', TestimonialController::class);
Route::resource('error', ErrorController::class); // pour 404
Route::post('bibliotheque/emprunter', [BibliothequeController::class, 'emprunter'])->name('bibliotheque.emprunter');
Route::delete('emprunts/{emprunt}', [BibliothequeController::class, 'destroy'])->name('emprunts.destroy');

// Page publique Emprunts (liste et formulaire d'emprunt)
Route::get('emprunts', function () {
    $livres = \App\Models\Catalogue::where('type_categorie', 'emprunt')->get();
    $user = Auth::user();
    $emprunts = $user ? $user->emprunts()->with('livre')->get() : collect();
    return view('emprunts', compact('livres', 'emprunts'));
})->name('emprunts.index');


// Routes pour le panier d'achat
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/modifier/{id}', [PanierController::class, 'modifier'])->name('panier.modifier');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::post('/panier/payer', [PanierController::class, 'payer'])->name('panier.payer');
Route::get('/paiement', [PanierController::class, 'showPaiement'])->name('paiement.show');
// Route pour payement Cash on Delivery (autorise aussi les invités)
Route::post('/commande/cod', [CommandeController::class, 'storeCod'])->name('commande.cod');
Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');


// Routes resource pour l'administration avec middleware d'authentification
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::post('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::resource('users', UserController::class);
    Route::resource('events', EventAdminController::class);
    Route::resource('donations', DonationAdminController::class);
    Route::resource('contacts', ContactAdminController::class);
    Route::resource('testimonials', TestimonialAdminController::class);
    Route::resource('quiz', QuizAdminController::class);
    Route::resource('certifications', CertificationAdminController::class);
    Route::resource('catalogue', CatalogueAdminController::class);
    Route::resource('achats', AchatAdminController::class);
    Route::resource('modules', ModuleAdminController::class);
    Route::resource('team', TeamAdminController::class); // Pour le lien équipe dans la sidebar
    Route::resource('emprunts', EmpruntController::class);
        // Actions supplémentaires pour les emprunts
        Route::post('emprunts/{emprunt}/update-status', [EmpruntController::class, 'updateStatus'])->name('admin.emprunts.updateStatus');
        Route::post('emprunts/{user}/bulk-update-status', [EmpruntController::class, 'bulkUpdateStatus'])->name('admin.emprunts.bulkUpdateStatus');
    Route::post('emprunts/add-books', [EmpruntController::class, 'addBooks'])->name('emprunts.addBooks');
    Route::resource('formations', AdminFormationController::class);
    // Admin: commandes management
    Route::get('commandes', [\App\Http\Controllers\Admin\CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'show'])->name('commandes.show');
    Route::patch('commandes/{commande}/status', [\App\Http\Controllers\Admin\CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
    Route::post('commandes/user/{user}/bulk-status', [\App\Http\Controllers\Admin\CommandeController::class, 'bulkUpdateStatus'])->name('commandes.bulkStatus');
});


// Routes pour le tableau de bord utilisateur
Route::middleware('auth')->group(function () {    
    // Routes pour Mon compte
    Route::get('account/profil', [App\Http\Controllers\AccountController::class, 'profil'])->name('account.profil');
    Route::get('account/commandes', [App\Http\Controllers\CommandeController::class, 'mesCommandes'])->name('account.commandes');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

