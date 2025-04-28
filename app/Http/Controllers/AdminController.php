<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\project;
use App\Models\service;
use App\Models\cagnotte;
use App\Models\investment;
use App\Models\projectOwner;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Session;
use App\Models\Notificationpv;


class AdminController extends Controller
{

    



        public function showSessions() {
            $sessions = Session::with('user')->orderBy('last_activity', 'desc')->get();
            return view('admin.sessions', compact('sessions'));
        }
        
            public function users()
        {
            $users = User::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.users', compact('users'));
        }


        public function showUser($id)
        {
            // Chargement des relations : projects → cagnotte et services
            $user = User::with([
                'projectOwner.projects.cagnotte',
                'projectOwner.services'
            ])->findOrFail($id);
        
            // Récupération des projets, campagnes (alias de cagnottes), et services
            $projects = $user->projectOwner ? $user->projectOwner->projects : collect([]);
            $campaigns = collect(); // par défaut vide
        
            // Extraire les cagnottes depuis les projets
            if ($projects->isNotEmpty()) {
                foreach ($projects as $project) {
                    if ($project->cagnotte) {
                        $campaigns->push($project->cagnotte);
                    }
                }
            }
        
            $services = $user->projectOwner ? $user->projectOwner->services : collect([]);
        
            return view('admin.show_user', compact('user', 'projects', 'campaigns', 'services'));
        }
        
        
        
        

        public function editUser($id)
        {
            $user = User::findOrFail($id); // Récupère l'utilisateur par son ID
            return view('admin.edit_user', compact('user')); // Retourne la vue d'édition de l'utilisateur
        }

        // Met à jour les informations d'un utilisateur
        public function updateUser(Request $request, $id)
        {
            $user = User::findOrFail($id); // Trouve l'utilisateur par son ID

            // Valider les données du formulaire d'édition
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                // Ajoutez d'autres champs de validation si nécessaire
            ]);

            // Mise à jour des données de l'utilisateur
            $user->update($validatedData);

            // Rediriger vers la page des utilisateurs avec un message de succès
            return redirect()->route('users')->with('success', 'Utilisateur mis à jour avec succès.');
        }


       
        
        public function updateUserRole(Request $request, $id)
        {
            $request->validate([
                'role' => 'required|in:investor,Project_owner,admin',
            ]);
        
            $user = User::findOrFail($id);
            $ancienRole = $user->role;
        
            $user->role = $request->role;
            $user->save();
        
            // Si le rôle devient Project_owner, on envoie une notification
            if ($request->role === 'Project_owner') {
                Notificationpv::create([
                    'user_id' => $user->id,
                    'title' => '🎉 Félicitations !',
                    'message' => 'Vous êtes maintenant porteur de projet sur Agrifund. Vous pouvez créer vos campagnes et services.',
                    'type' => 'validation',
                    'lu' => 0,
                ]);
            }
        
            return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
        }

        public function validateCampaign($id)
{
    // Trouver la campagne
    $campaign = Cagnotte::findOrFail($id);

    // Mettre à jour le statut de la campagne et la date de fin
    $campaign->status = 'open'; // ou 'validated', selon ton workflow
    $campaign->updated_at = now(); // Date de validation
    $campaign->date_fin = now()->addDays(90); // Ajoute 90 jours à la date actuelle pour la date de fin
    $campaign->save();

    // Vérifier si la campagne a un propriétaire de projet (ProjectOwner)
    if ($campaign->project->projectOwner) {
        // Accéder à l'utilisateur via le project_owner
        $user = $campaign->project->projectOwner->user;

        // Créer une notification pour cet utilisateur
        Notificationpv::create([ 
            'user_id' => $user->id,
            'title' => '🎉 Validation',
            'message' => 'Votre campagne est validée.',
            'type' => 'validation',
            'lu' => 0, // 0 pour non-lu
        ]);
    } else {
        // Si aucun project_owner n'est trouvé, gérer l'erreur ou afficher un message
        return back()->with('error', 'Aucun propriétaire de projet trouvé pour cette campagne.');
    }

    // Retourner à la page précédente avec un message de succès
    return back()->with('success', 'La campagne a été validée avec succès.');
}

        

        
        




        // Supprime un utilisateur
            public function deleteUser($id)
            {
                $user = User::findOrFail($id); // Trouve l'utilisateur par son ID

                // Supprimer l'utilisateur
                $user->delete();

                // Rediriger avec un message de succès
                return redirect()->route('users')->with('success', 'Utilisateur supprimé avec succès.');
            }


        
            
            public function loginhistorys()
            {
                $logins = LoginHistory::latest()->paginate(10);
                $totalLogins = LoginHistory::count();  // Ajoutez cette ligne pour compter les historiques de connexion
                return view('admin.loginhistory', compact('logins', 'totalLogins'));
            }

            
            public function approveProject($id)
            {
                $project = Project::findOrFail($id);
                $project->status = 'approved';
                $project->save();
                return redirect()->route('admin.dashboard')->with('success', 'Projet approuvé');
            }

            public function approveService($id)
            {
                $service = Service::findOrFail($id);
                $service->status = 'approved';
                $service->save();
                return redirect()->route('admin.dashboard')->with('success', 'Service approuvé');
            }

            public function listCampaigns()
            {
                // Charger toutes les campagnes et trier par date de création
                $campaigns = Cagnotte::orderBy('created_at', 'desc')->get();
            
                return view('admin.campaigns', compact('campaigns'));
            }
            

                    public function showcampaign($id)
            {
                $campaign = cagnotte::with(['project'])->findOrFail($id);
                return view('admin.show_campaign', compact('campaign'));
            }


                public function cancel(Request $request, $id)
    {
        $cagnotte = Cagnotte::findOrFail($id);

        // Vérifier que la cagnotte n'est pas déjà fermée
        if ($cagnotte->status === 'closed' || $cagnotte->status === 'failed') {
            return redirect()->back()->with('error', 'Cette cagnotte est déjà fermée ou annulée.');
        }

        // Récupérer le message envoyé par l'admin
        $message = $request->input('message');
        if (!$message) {
            return redirect()->back()->with('error', 'Vous devez entrer un message d\'annulation.');
        }

        // Mettre à jour le statut de la cagnotte
        $cagnotte->status = 'failed';
        $cagnotte->save();

        // Récupérer les investissements
        $investments = Investment::where('cagnotte_id', $cagnotte->id)->get();

        foreach ($investments as $investment) {
            // Rembourser l'investisseur
            $wallet = Wallet::where('user_id', $investment->user_id)->first();
            if ($wallet) {
                $wallet->balance += $investment->amount;
                $wallet->save();
            }

            // Enregistrer une transaction de remboursement
            Transaction::create([
                'user_id' => $investment->user_id,
                'type' => 'refund',
                'amount' => $investment->amount,
                'status' => 'pending',
                'description' => 'Remboursement suite à l\'annulation de la cagnotte "' . $cagnotte->titre . '"',
            ]);

            // Mettre à jour l'investissement au lieu de le supprimer
            $investment->status = 'refunded';
            $investment->save();

        // Notification
                Notificationpv::create([
                    'user_id' => $investment->user_id,
                    'title' => 'Annulation de campagne',
                    'message' => "Une campagne dans laquelle vous avez investi " . number_format($investment->amount, 2) . " € a été annulée. Le montant a été remboursé sur votre portefeuille.",
                    'type' => 'info',
                    'lu' => 0,
                ]);
            }

            
                // Ajouter une notification pour l'agronome
                if ($cagnotte->project && $cagnotte->project->owner) {
                    Notificationpv::create([
                        'user_id' => $cagnotte->project->owner->user_id,
                        'title' => 'Annulation de votre campagne',
                        'message' => $message,
                        'type' => 'alerte',
                        'lu' => 0,
                    ]);
                }
            
                // Réduire les fonds collectés à 0
                $cagnotte->collected_amount = 0;
                $cagnotte->status = 'failed';
                $cagnotte->save();
            
                // Mettre à jour le projet si nécessaire
                $project = Project::find($cagnotte->project_id);
                if ($project) {
                    $project->current_amount -= $cagnotte->collected_amount;
                    $project->save();
                }
            
                return redirect()->back()->with('success', 'La cagnotte a été annulée avec succès et les fonds ont été retournés aux investisseurs.');
            }
            
            public function updateProjectStatus(Request $request, $id)
            {
                $project = Project::findOrFail($id);
                $newStatus = $request->input('status');
                $message = $request->input('message');
            
                if ($project->status !== $newStatus) {
                    // Envoyer une notification à l'agronome
                    Notificationpv::create([
                        'user_id' => $project->owner->user_id,
                        'title' => 'Mise à jour du statut de votre projet',
                        'message' => "Le statut de votre projet '{$project->title}' a été mis à jour en '{$newStatus}'. Message de l'administrateur : {$message}",
                        'type' => 'alerte',
                        'lu' => 0,
                    ]);
            
                    // Mettre à jour le statut du projet
                    $project->status = $newStatus;
                    $project->save();
                }
            
                return redirect()->back()->with('success', 'Statut du projet mis à jour avec succès.');
            }
            
                        public function projects()
            {
                $projects = Project::all(); // Ou ta logique pour récupérer les projets
                return view('admin.projects', compact('projects'));
            }


            public function services()
            {
                // Trier les services en fonction du statut : Pending en premier, puis Approved, puis Rejected
                $services = Service::orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected')")
                                    ->orderBy('created_at', 'desc') // Puis trier par date de création (du plus récent au plus ancien)
                                    ->get();
            
                return view('admin.services', compact('services'));
            }
            


                    public function showService($id)
            {
                // Récupérer le service par son ID
                $service = Service::findOrFail($id);

                // Retourner la vue avec les détails du service
                return view('admin.show_service', compact('service'));
            }

            public function updateServiceStatus(Request $request, $id)
{
    $service = Service::findOrFail($id);
    $newStatus = $request->input('status');
    $message = $request->input('message');

    if ($service->status !== $newStatus) {
        // Envoyer une notification à l'agronome
        Notificationpv::create([
            'user_id' => $service->owner->user_id,
            'title' => 'Mise à jour du statut de votre service',
            'message' => "Le statut de votre service '{$service->title}' a été mis à jour en '{$newStatus}'. Message de l'administrateur : {$message}",
            'type' => 'alerte',
            'lu' => 0,
        ]);

        // Mettre à jour le statut du service
        $service->status = $newStatus;
        $service->save();

        return redirect()->back()->with('success', 'Statut du service mis à jour avec succès.');
    } else {
        return redirect()->back()->with('error', 'Aucune modification n\'a été apportée car le statut est déjà le même.');
    }
}





            public function listInvestments()
            {
                // Charger les relations et trier par date de création (du plus récent au plus ancien)
                $investments = Investment::with(['investor', 'project'])
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            
                return view('admin.investment', compact('investments'));
            }
            

            public function showInvestment($id)
            {
                $investment = Investment::with(['investor', 'project'])->findOrFail($id);
                return view('admin.show_investment', compact('investment'));
            }

            public function editInvestment($id)
            {
                $investment = Investment::findOrFail($id);
                return view('admin.edit_investment', compact('investment'));
            }

            public function updateInvestment(Request $request, $id)
            {
                $request->validate([
                    'amount' => 'required|numeric|min:1',
                    'status' => 'required|string',
                ]);

                $investment = Investment::findOrFail($id);
                $investment->update([
                    'amount' => $request->amount,
                    'status' => $request->status,
                ]);

                return redirect()->route('investments')->with('success', 'Investissement mis à jour avec succès.');
            }

            public function deleteInvestment($id)
            {
                Investment::findOrFail($id)->delete();
                return redirect()->route('investments')->with('success', 'Investissement supprimé avec succès.');
            }



            public function listProjectOwners()
            {
                // Charger la relation "user" et trier par date de création
                $projectOwners = ProjectOwner::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->get();
            
                return view('admin.project_owners', compact('projectOwners'));
            }
            

            public function projectOwners()
        {
            $owners = ProjectOwner::with('user')
            ->orderBy('updated_at', 'desc')
            ->get();
            return view('admin.project_owners', compact('owners'));

        }

                public function showProject($id)
        {
            $project = Project::findOrFail($id);
            
            return view('admin.show_project', compact('project'));
        }

        // Affichage d’un propriétaire de projet
        public function showProjectOwner($id)
        {
            $owner = ProjectOwner::with('user')->findOrFail($id);
            return view('admin.show_project_owner', compact('owner'));
        }

        // Formulaire de modification
        public function editProjectOwner($id)
        {
            $owner = ProjectOwner::findOrFail($id);
            return view('admin.edit_project_owner', compact('owner'));
        }

        // Mise à jour
        public function updateProjectOwner(Request $request, $id)
        {
            $owner = ProjectOwner::findOrFail($id);
            $owner->update($request->only(['verification_status', 'justification_document']));
            return redirect()->route('admin.project_owners')->with('success', 'Mise à jour réussie');
        }

        // Suppression
        public function deleteProjectOwner($id)
        {
            ProjectOwner::findOrFail($id)->delete();
            return redirect()->route('admin.project_owners')->with('success', 'Propriétaire supprimé');
        }

        public function updateOwnerStatus(Request $request, $id)
        {
            $owner = ProjectOwner::findOrFail($id);
            $newStatus = $request->input('verification_status');
            $notificationMessage = $request->input('notification_message');
        
            // Mise à jour du statut du propriétaire
            $owner->verification_status = $newStatus;
            $owner->save();
        
            // Envoi de la notification au propriétaire
            Notificationpv::create([
                'user_id' => $owner->user_id,
                'title' => 'Mise à jour du statut de votre compte',
                'message' => $notificationMessage,
                'type' => 'alerte',
                'lu' => 0,
            ]);
        
            // Retour de la réponse avec un message de succès ou d'erreur
            return redirect()->route('admin.show_project_owner', $owner->id)
                             ->with('success', 'Le statut du propriétaire a été mis à jour avec succès et la notification a été envoyée.');
        }
        


        public function listTransactions()
        {
            // Charger la relation "user" et trier par date de création
            $transactions = Transaction::with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        
            return view('admin.transactions', compact('transactions'));
        }
        

        public function showTransaction($id)
        {
            $transaction = Transaction::with('user')->findOrFail($id);
            return view('admin.show_transaction', compact('transaction'));
        }

                public function updateTransactionStatus($transactionId)
        {
            // Récupérer la transaction par ID
            $transaction = Transaction::findOrFail($transactionId);
            $user = $transaction->user;

            // Récupérer le wallet de l'utilisateur
            $wallet = Wallet::where('user_id', $user->id)->first();

            // Changer le statut de la transaction
            $transaction->status = 'completed';
            $transaction->save();

            // Si le statut est "completed", soustraire le montant du wallet de l'utilisateur
            if ($transaction->status === 'completed') {
                if ($wallet && $wallet->balance >= $transaction->amount) {
                    // Soustraire le montant du wallet
                    $wallet->balance -= $transaction->amount;
                    $wallet->save();

                    // Créer une notification pour l'utilisateur
                    Notificationpv::create([
                        'user_id' => $user->id,
                        'title' => '✅ Transaction approuvée',
                        'message' => 'Votre transaction de ' . number_format($transaction->amount, 2) . ' € a été approuvée.',
                        'type' => 'paiement',
                        'lu' => 0,
                    ]);

                    return redirect()->route('admin.transactions')->with('success', 'Transaction terminée, montant soustrait et notification envoyée.');
                } else {
                    return redirect()->back()->with('error', 'Solde insuffisant pour effectuer cette transaction.');
                }
            }

            return redirect()->route('admin.transactions')->with('success', 'Transaction mise à jour avec succès.');
        }

        public function listWallets()
        {
            // Charger la relation "user" et trier par date de création
            $wallets = Wallet::with('user')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
            return view('admin.wallets', compact('wallets'));
        }
        

        public function showWallet($id)
        {
            $wallet = Wallet::with('user')->findOrFail($id);
            return view('admin.show_wallet', compact('wallet'));
        }

    }
