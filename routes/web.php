<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;

// Routes resource pour l'administration
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\DonationAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\Admin\QuizAdminController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizQuestionController;
use App\Http\Controllers\QuizController as FrontQuizController;
use App\Http\Controllers\Admin\CertificationAdminController;
use App\Http\Controllers\Admin\CatalogueAdminController;
use App\Http\Controllers\Admin\AchatController as AchatAdminController;
use App\Http\Controllers\Admin\ModuleAdminController;
use App\Http\Controllers\Admin\TeamAdminController;
use App\Http\Controllers\Admin\EquipeAdminController;
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
use App\Http\Controllers\EmpruntUserController;
use App\Http\Controllers\SecurePdfController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Admin\BlogAdminController;

// Route d'accueil nommée 'index' pour la page principale
Route::get('/', [IndexController::class, 'index'])->name('index');

// Blog
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Testimonials (public)
Route::post('testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// Routes pour Apprendre
Route::get('formation/modules', [FormationController::class, 'modules'])->name('formation.modules');
Route::get('formation/quiz', [FormationController::class, 'quiz'])->name('formation.quiz');
Route::get('formation/certification', [FormationController::class, 'certification'])->name('formation.certification');
// Route de détail d'une formation
Route::get('formation/{formation}', [FormationController::class, 'show'])->name('formation.show');
Route::post('formation/{formation}/acheter', [FormationController::class, 'acheter'])->name('formation.acheter');
Route::get('formation/{formation}/paiement', [FormationController::class, 'paiement'])->name('formation.paiement');
Route::post('formation/{formation}/traiter-paiement', [FormationController::class, 'traiterPaiement'])->name('formation.traiter-paiement');
Route::get('formation/{formation}/module/{module}', [FormationController::class, 'moduleShow'])->name('formation.module.show');
Route::post('formation/{formation}/module/{module}/contenu/{contenu}/complete', [FormationController::class, 'markContenuCompleted'])->middleware('auth')->name('formation.module.contenu.complete');
Route::post('formation/{formation}/module/{module}/contenu/{contenu}/update-video-progress', [FormationController::class, 'updateVideoProgress'])->middleware('auth')->name('formation.module.contenu.update-video-progress');

// Route pour le visualiseur PDF sécurisé (page dédiée)
Route::get('formation/{formation}/module/{module}/pdf/{contenu}', [\App\Http\Controllers\PdfViewerController::class, 'show'])->middleware('auth')->name('pdf.viewer.show');

// Routes pour Catalogue
Route::get('catalogue/decouvrir', [CatalogueController::class, 'decouvrir'])->name('catalogue.decouvrir');
Route::get('catalogue/emprunts', [CatalogueController::class, 'acheter'])->name('catalogue.acheter');
// Route index compatible avec les appels existants
Route::get('catalogue', [CatalogueController::class, 'decouvrir'])->name('catalogue.index');

// Routes pour Emprunts (utilisateurs)
Route::get('emprunts', [EmpruntUserController::class, 'index'])->name('emprunts.index');
Route::get('emprunts/{id}', [EmpruntUserController::class, 'show'])->name('emprunts.show');

// Routes protégées pour les emprunts utilisateur
Route::middleware('auth')->group(function () {
    Route::get('mes-emprunts', [EmpruntUserController::class, 'mesEmprunts'])->name('emprunts.mes-emprunts');
    Route::post('emprunts/demander', [EmpruntUserController::class, 'demander'])->name('emprunts.demander');
});

// Routes pour la visualisation sécurisée des PDFs
Route::get('secure-pdf/view/{id}', [SecurePdfController::class, 'view'])->name('secure-pdf.view');
Route::get('secure-pdf/serve/{id}', [SecurePdfController::class, 'serve'])->name('secure-pdf.serve');

// Routes pour les paiements
Route::middleware('auth')->group(function () {
    // Paiements pour formations
    Route::get('paiement/kkiapay/{inscription}', [PaiementController::class, 'kkiapay'])->name('paiement.kkiapay');
    Route::match(['get', 'post'], 'paiement/kkiapay/callback', [PaiementController::class, 'kkiapayCallback'])->name('paiement.kkiapay.callback');

    Route::get('paiement/paypal/{inscription}', [PaiementController::class, 'paypal'])->name('paiement.paypal');
    Route::get('paiement/paypal/callback', [PaiementController::class, 'paypalCallback'])->name('paiement.paypal.callback');

    Route::get('paiement/annuler/{inscription}', [PaiementController::class, 'annuler'])->name('paiement.annuler');

    // Routes pour les paiements TEST/SIMULATION
    Route::get('paiement/test/formation/{inscription}', [PaiementController::class, 'testFormation'])->name('paiement.test.formation');
    Route::post('paiement/test/formation/{inscription}/validate', [PaiementController::class, 'testFormationValidate'])->name('paiement.test.formation.validate');

    Route::get('paiement/test/catalogue/{commande}', [PaiementController::class, 'testCatalogue'])->name('paiement.test.catalogue');
    Route::post('paiement/test/catalogue/{commande}/validate', [PaiementController::class, 'testCatalogueValidate'])->name('paiement.test.catalogue.validate');

    // Paiements pour commandes (catalogue)
    Route::get('paiement/catalogue/kkiapay/{commande}', [PaiementController::class, 'catalogueKkiapay'])->name('paiement.catalogue.kkiapay');
    Route::match(['get', 'post'], 'paiement/catalogue/kkiapay/callback', [PaiementController::class, 'catalogueKkiapayCallback'])->name('paiement.catalogue.kkiapay.callback');

    Route::get('paiement/catalogue/paypal/{commande}', [PaiementController::class, 'cataloguePaypal'])->name('paiement.catalogue.paypal');
    Route::get('paiement/catalogue/paypal/callback', [PaiementController::class, 'cataloguePaypalCallback'])->name('paiement.catalogue.paypal.callback');
});

// Routes resource pour chaque page principale
Route::resource('about', AboutController::class);
Route::resource('contact', ContactController::class);
Route::resource('donation', DonationController::class);
Route::resource('event', EventController::class);
Route::resource('feature', FeatureController::class);
Route::resource('service', ServiceController::class);
Route::resource('team', TeamController::class);
Route::get('equipe', [EquipeController::class, 'index'])->name('equipe.index');
Route::resource('testimonial', TestimonialController::class);
Route::resource('error', ErrorController::class); // pour 404
Route::post('bibliotheque/emprunter', [BibliothequeController::class, 'emprunter'])->name('bibliotheque.emprunter');
Route::delete('emprunts/{emprunt}', [BibliothequeController::class, 'destroy'])->name('emprunts.destroy');


// Routes pour le panier d'achat
Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/modifier/{id}', [PanierController::class, 'modifier'])->name('panier.modifier');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::post('/panier/payer', [PanierController::class, 'payer'])->name('panier.payer');
Route::get('/paiement', [PanierController::class, 'showPaiement'])->name('paiement.show');
Route::post('/panier/traiter-paiement', [PanierController::class, 'traiterPaiement'])->name('panier.traiter-paiement');
// Route pour payement Cash on Delivery (autorise aussi les invités)
Route::post('/commande/cod', [CommandeController::class, 'storeCod'])->name('commande.cod');
Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');

// Routes pour l'authentification admin (AVANT le middleware)
Route::get('admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

// Route d'enregistrement admin ULTRA-SÉCURISÉE avec token secret
Route::get('admin/register/{token}', [\App\Http\Controllers\Admin\AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('admin/register/{token}', [\App\Http\Controllers\Admin\AuthController::class, 'register'])->name('admin.register.post');

// Routes resource pour l'administration avec middleware d'authentification
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/users', [AdminDashboardController::class, 'getUsers'])->name('dashboard.users');
    Route::get('/dashboard/sales', [AdminDashboardController::class, 'getSales'])->name('dashboard.sales');
    Route::get('/dashboard/emprunts', [AdminDashboardController::class, 'getEmprunts'])->name('dashboard.emprunts');
    Route::post('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::resource('users', UserController::class);
    Route::resource('events', EventAdminController::class);
    Route::resource('donations', DonationAdminController::class);
    Route::resource('contacts', ContactAdminController::class);
    Route::post('contacts/{id}/toggle-read', [ContactAdminController::class, 'toggleRead'])->name('contacts.toggleRead');
    Route::resource('blog', BlogAdminController::class);
    Route::post('blog/{id}/toggle-status', [BlogAdminController::class, 'toggleStatus'])->name('blog.toggleStatus');

    // Testimonials Admin
    Route::get('testimonials', [TestimonialAdminController::class, 'index'])->name('testimonials.index');
    Route::post('testimonials/{id}/approve', [TestimonialAdminController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{id}/reject', [TestimonialAdminController::class, 'reject'])->name('testimonials.reject');
    Route::post('testimonials/{id}/pending', [TestimonialAdminController::class, 'pending'])->name('testimonials.pending');
    Route::delete('testimonials/{id}', [TestimonialAdminController::class, 'destroy'])->name('testimonials.destroy');
    // Route::resource('quiz', QuizAdminController::class); // Ancien contrôleur
    // Nouveau système de quiz
    Route::resource('quizzes', QuizController::class);
    Route::post('quizzes/{quiz}/questions', [QuizQuestionController::class, 'store'])->name('quizzes.questions.store');
    Route::put('quiz-questions/{question}', [QuizQuestionController::class, 'update'])->name('quiz-questions.update');
    Route::delete('quiz-questions/{question}', [QuizQuestionController::class, 'destroy'])->name('quiz-questions.destroy');
    Route::post('quizzes/{quiz}/questions/reorder', [QuizQuestionController::class, 'reorder'])->name('quizzes.questions.reorder');
    // Certifications
    Route::resource('certifications', CertificationAdminController::class);
    Route::post('certifications/{inscription}/generate', [CertificationAdminController::class, 'generate'])->name('certifications.generate');
    Route::post('certifications/generate-manual', [CertificationAdminController::class, 'generateManual'])->name('certifications.generate-manual');
    Route::get('certifications/{certificat}/download', [CertificationAdminController::class, 'download'])->name('certifications.download');
    Route::post('certifications/{certificat}/send-email', [CertificationAdminController::class, 'sendEmail'])->name('certifications.send-email');
    Route::post('certifications/{certificat}/send-email-custom', [CertificationAdminController::class, 'sendEmailCustom'])->name('certifications.send-email-custom');
    Route::patch('certifications/{certificat}/change-status', [CertificationAdminController::class, 'changeStatus'])->name('certifications.change-status');
    Route::post('certifications/clear-cache', [CertificationAdminController::class, 'clearCache'])->name('certifications.clear-cache');

    Route::resource('catalogue', CatalogueAdminController::class);
    Route::resource('achats', AchatAdminController::class);
    Route::resource('modules', ModuleAdminController::class);
    Route::resource('team', TeamAdminController::class); // Pour le lien équipe dans la sidebar
    Route::resource('equipe', EquipeAdminController::class); // Nouvelle gestion d'équipe avec BDD
    Route::resource('emprunts', EmpruntController::class);
    // Actions supplémentaires pour les emprunts
    Route::post('emprunts/{emprunt}/update-status', [EmpruntController::class, 'updateStatus'])->name('emprunts.updateStatus');
    Route::post('emprunts/{user}/bulk-update-status', [EmpruntController::class, 'bulkUpdateStatus'])->name('emprunts.bulkUpdateStatus');
    Route::post('emprunts/add-books', [EmpruntController::class, 'addBooks'])->name('emprunts.addBooks');
    // Gestion des livres empruntables (catalogue)
    Route::put('emprunts/livre/{id}', [EmpruntController::class, 'updateLivre'])->name('emprunts.updateLivre');
    Route::delete('emprunts/livre/{id}', [EmpruntController::class, 'destroyLivre'])->name('emprunts.destroyLivre');
    // Validation des demandes d'emprunt
    Route::post('emprunts/{emprunt}/valider', [EmpruntController::class, 'validerDemande'])->name('emprunts.valider');
    Route::post('emprunts/{emprunt}/rejeter', [EmpruntController::class, 'rejeterDemande'])->name('emprunts.rejeter');
    Route::post('emprunts/{emprunt}/renew-access', [EmpruntController::class, 'renewAccess'])->name('emprunts.renew-access');

    // Gestion des utilisateurs
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/toggle-block', [\App\Http\Controllers\Admin\UserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::post('users/{user}/change-role', [\App\Http\Controllers\Admin\UserController::class, 'changeRole'])->name('users.change-role');
    Route::resource('formations', AdminFormationController::class);
    Route::resource('modules', \App\Http\Controllers\Admin\ModuleController::class);
    Route::resource('modules.contenus', \App\Http\Controllers\Admin\ModuleContenuController::class)->shallow();
    // Admin: commandes management
    Route::get('commandes', [\App\Http\Controllers\Admin\CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{commande}', [\App\Http\Controllers\Admin\CommandeController::class, 'show'])->name('commandes.show');
    Route::patch('commandes/{commande}/status', [\App\Http\Controllers\Admin\CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
    Route::post('commandes/user/{user}/bulk-status', [\App\Http\Controllers\Admin\CommandeController::class, 'bulkUpdateStatus'])->name('commandes.bulkStatus');
});


// Route de test (sans auth)
Route::get('test-layout', function() {
    return view('test-layout');
});

// Routes pour le tableau de bord utilisateur
Route::middleware('auth')->group(function () {
    // Routes pour Mon compte
    Route::get('account/profil', [App\Http\Controllers\AccountController::class, 'profil'])->name('account.profil');
    Route::post('account/avatar', [App\Http\Controllers\AccountController::class, 'updateAvatar'])->name('account.avatar.update');
    Route::post('account/profil/update', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.profil.update');
    Route::get('account/commandes', [App\Http\Controllers\CommandeController::class, 'mesCommandes'])->name('account.commandes');

    // Routes pour les quiz (front-end)
    Route::get('quiz/{quiz}', [FrontQuizController::class, 'show'])->name('quiz.show');
    Route::post('quiz/{quiz}/start', [FrontQuizController::class, 'start'])->name('quiz.start');
    Route::post('quiz/{quiz}/attempt/{attempt}/submit', [FrontQuizController::class, 'submit'])->name('quiz.submit');
    Route::get('quiz/{quiz}/attempt/{attempt}/result', [FrontQuizController::class, 'result'])->name('quiz.result');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

