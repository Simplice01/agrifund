<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgronomistController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 📌 Page d'accueil
// Route publique pour la page d'accueil
// Route::get('/', function () {
//     if (auth()->check()) {
//         return redirect()->route('user.dashboard');
//     }     
//     return view('home');
// })->name('home');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/campaigns', [UserController::class, 'campaigns'])->name('campaigns');
Route::get('/services', [UserController::class, 'services'])->name('user.services');


// Routes pour les utilisateurs non connectés
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard'); // Utilise une autre route
    Route::get('/campaigns/{id}', [UserController::class, 'showCampaign'])->name('user.show_campaign');
    Route::get('/services/{id}', [UserController::class, 'showService'])->name('user.show_service');
    Route::get('/projects/{id}', [UserController::class, 'showProject'])->name('user.show_project');
    Route::post('/contribute', [UserController::class, 'store'])->name('contribute.store');
    
    Route::get('/notifications', [UserController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [UserController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [UserController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/user/transactions', [UserController::class, 'showTransactions'])->name('user.transactions');
    Route::post('/user/transactions', [UserController::class, 'storeTransaction'])->name('user.transactions.store');


});



// 📌 Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 📌 Réinitialisation du mot de passe
Route::prefix('password')->group(function () {
    Route::get('/reset', [AuthController::class, 'showResetForm'])->name('password.request');
    Route::post('/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset/{token}', [AuthController::class, 'showResetFormWithToken'])->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset'])->name('password.update');
});

// 📌 Routes Utilisateur Authentifié
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::put('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::get('/user/{id}', [UserController::class, 'showUser'])->name('user.showUser');

});

// 📌 Routes Agronome
Route::middleware(['auth', 'role:agronome'])->prefix('agronome')->group(function () {
    Route::get('/services', [AgronomistController::class, 'listServices'])->name('agronomist.services');
    Route::get('/projects', [AgronomistController::class, 'listProjects'])->name('agronomist.projects');
    Route::get('/campaigns', [AgronomistController::class, 'listCampaigns'])->name('agronomist.campaigns');
});

// 📌 Routes Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // 🔹 Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.show_user'); // ✅ Ajout de la route
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.edit_user');
    Route::put('/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.update_user');
    Route::delete('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.delete_user');
    // Route::post('/users/{id}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.updateUserRole');
    Route::post('/admin/users/{id}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.updateUserRole');

    // 🔹 Gestion des campagnes
    Route::get('/campaigns', [AdminController::class, 'listCampaigns'])->name('admin.campaigns');
    Route::get('/campaigns/{id}/edit', [AdminController::class, 'editCampaign'])->name('admin.edit_campaign');
    Route::put('/campaigns/{id}', [AdminController::class, 'updateCampaign'])->name('admin.update_campaign');
    Route::delete('/campaigns/{id}', [AdminController::class, 'deleteCampaign'])->name('admin.delete_campaign');
    Route::get('/campaigns/{id}', [AdminController::class, 'showcampaign'])->name('admin.show_campaign'); // ✅ Ajout de la route
    Route::post('/campaigns/{id}/cancel', [AdminController::class, 'cancel'])->name('campaigns.cancel');
    Route::post('/campaigns/{id}/validate', [AdminController::class, 'validateCampaign'])->name('campaigns.validate');


    // 🔹 Gestion des projets
    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::get('/projects/{id}/edit', [AdminController::class, 'editProject'])->name('admin.edit_project');
    Route::put('/projects/{id}', [AdminController::class, 'updateProject'])->name('admin.update_project');
    Route::delete('/projects/{id}', [AdminController::class, 'deleteProject'])->name('admin.delete_project');
    Route::get('/projects/{id}', [AdminController::class, 'showProject'])->name('admin.show_project');
    Route::put('/admin/projects/{id}/status', [AdminController::class, 'updateProjectStatus'])->name('admin.updateProjectStatus');



    // 🔹 Gestion des services
   
    Route::get('/services', [AdminController::class, 'services'])->name('admin.services');
    Route::get('/services/{id}', [AdminController::class, 'showService'])->name('admin.show_service');
    Route::get('/services/{id}/edit', [AdminController::class, 'editService'])->name('admin.edit_service');
    Route::put('/services/{id}', [AdminController::class, 'updateService'])->name('admin.update_service');
    Route::delete('/services/{id}', [AdminController::class, 'deleteService'])->name('admin.delete_service');
    Route::put('/services/{id}/update-status', [AdminController::class, 'updateServiceStatus'])->name('admin.updateServiceStatus');

    
    // 🔹 Gestion des transactions et investissements
    Route::get('/investments', [AdminController::class, 'listInvestments'])->name('admin.investments');
    Route::get('/investments/{id}/edit', [AdminController::class, 'editInvestment'])->name('admin.edit_investment');
    Route::put('/investments/{id}', [AdminController::class, 'updateInvestment'])->name('admin.update_investment');
    Route::delete('/investments/{id}', [AdminController::class, 'deleteInvestment'])->name('admin.delete_investment');
    Route::get('/investments/{id}', [AdminController::class, 'showInvestment'])->name('admin.show_investment');

    

    Route::get('/transactions', [AdminController::class, 'listTransactions'])->name('admin.transactions');
    Route::get('/transactions/{id}', [AdminController::class, 'showTransaction'])->name('admin.show_transaction');
    Route::post('/transaction/{transactionId}/update-status', [AdminController::class, 'updateTransactionStatus'])->name('transaction.updateStatus');


    // 🔹 Gestion des abonnements
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions');
    Route::delete('/subscription/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.delete_subscription');

    // 🔹 Gestion des portefeuilles
    Route::get('/wallets', [AdminController::class, 'listWallets'])->name('admin.wallets');
    Route::get('/wallets/{id}', [AdminController::class, 'showWallet'])->name('admin.show_wallet');

    // 🔹 Gestion des propriétaires de projets (Project Owners)
    
    Route::put('/admin/projects-owners/{id}/status', [AdminController::class, 'updateOwnerStatus'])->name('admin.updateOwnerStatus');

    Route::get('/project-owners', [AdminController::class, 'projectOwners'])->name('admin.project_owners');
    Route::get('/project-owner/{id}', [AdminController::class, 'showProjectOwner'])->name('admin.show_project_owner');
    Route::get('/project-owner/{id}/edit', [AdminController::class, 'editProjectOwner'])->name('admin.edit_project_owner');
    Route::put('/project-owner/{id}', [AdminController::class, 'updateProjectOwner'])->name('admin.update_project_owner');
    Route::delete('/project-owner/{id}', [AdminController::class, 'deleteProjectOwner'])->name('admin.delete_project_owner');
    Route::put('/admin/owner/{owner}/status', [AdminController::class, 'updateOwnerStatus'])->name('admin.update_owner_status');
    Route::put('/admin/projects/{id}/update-status', [AdminController::class, 'updateProjectStatus'])->name('admin.update_project_status');

    Route::get('/sessions', [AdminController::class, 'showSessions'])->name('admin.sessions');

});
