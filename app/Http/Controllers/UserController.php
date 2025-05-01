<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\Campaign;
use App\Models\User;
use App\Models\project;
use App\Models\Service;
use App\Models\wallet;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Cagnotte;
use App\Models\ProjectOwner; 
use App\Models\Notificationpv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    public function dashboard() 
    {
        $user = auth()->user();  // Récupérer l'utilisateur connecté
        
        // Définition des variables par défaut
        $totalContributions = 0;
        $totalContributionAmount = 0;
        $userContributions = collect(); // Liste vide
        $walletBalance = 0;
        
        // Si l'utilisateur est un investisseur
        if ($user->role == 'investor') {
            $totalContributions = Investment::where('user_id', $user->id)->count();
            $totalContributionAmount = Investment::where('user_id', $user->id)->sum('amount');
            $userContributions = Investment::where('user_id', $user->id)->get();
            $walletBalance = Wallet::where('user_id', $user->id)->value('balance') ?? 0;
        }
    
        // Total des investissements (pour tous les utilisateurs)
        $totalInvestments = Investment::sum('amount');
    
        // Liste des 5 campagnes actives
        $activeCampaigns = cagnotte::where('status', 'open')->latest()->take(5)->get();
    
        // Montant total des campagnes
        $totalCampaignsAmount = cagnotte::sum('target_amount');
    
        // Montant total collecté des campagnes
        $totalCampaignsAmountget = cagnotte::sum('collected_amount');
    
        // Total des utilisateurs
        $totalUsers = User::count();
    
        // Total des campagnes
        $totalCampaigns = cagnotte::count();
    
        // Total des projets
        $totalProjects = Project::count();
    
        // Liste des 5 projets en attente
        $pendingProjects = Project::where('status', 'pending')->latest()->take(5)->get();
    
        // Liste des 5 campagnes en attente
        $pendingCampaigns = cagnotte::where('status', 'pending')->latest()->take(5)->get();
    
        // Récupérer les transactions pour le graphe
        $transactions = Transaction::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    
        // Récupérer les 5 dernières notifications de l'utilisateur
        $notifications = auth()->user()->notificationpv()
        ->select('id', 'type', 'message', 'created_at') // Sélection des colonnes spécifiques
        ->where('lu', '0') // Récupérer uniquement les notifications non lues
        ->latest() // Trier par date, de la plus récente à la plus ancienne
        ->get();
        
        // Retourner la vue avec les informations
        return view('user.dashboard', compact(
            'totalInvestments', 
            'totalCampaignsAmount', 
            'totalUsers', 
            'totalCampaigns', 
            'totalProjects', 
            'pendingProjects', 
            'pendingCampaigns', 
            'transactions',
            'totalCampaignsAmountget',
            'activeCampaigns',
            'totalContributions', 
            'totalContributionAmount', 
            'userContributions', 
            'walletBalance',
            'notifications' // Ajout des notifications
        ));
    }
    

    

    public function showForm($id)
    {
        $campaign = Cagnotte::findOrFail($id);
        $agronome = $campaign->project->agronome ?? null;
    
        return view('user.contribute', compact('campaign', 'agronome'));
    }
    

    // UserController.php
    public function show($id)
    {
        // Récupérer l'utilisateur avec ses services
        $user = User::with('services')->findOrFail($id);
    
        // Passer les données à la vue
        return view('user.show_user', compact('user'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id); // Trouver l'utilisateur par son ID

        return view('user.show_user', compact('user')); // Retourner la vue avec les données utilisateur
    }
    


    
        public function wallet()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Passer l'utilisateur et son solde actuel à la vue
        return view('user.wallet', compact('user'));
    }


    // Afficher le formulaire de demande pour devenir agronome
    public function showAgronomistRequestForm()
    {
        return view('user.request_agronomist');
    }

    // Traiter la soumission du formulaire de demande
    public function submitAgronomistRequest(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'professional_experience' => 'required|string|max:1000',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
            'identity_document' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048', // 2MB max
            'certificate' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048', // 2MB max
        ]);

        // Télécharger les fichiers
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        $identityDocumentPath = $request->file('identity_document')->store('identity_documents', 'public');
        $certificatePath = $request->file('certificate')->store('certificates', 'public');

        // // Mettre à jour le rôle de l'utilisateur et les informations supplémentaires
        // $user = Auth::user();
        // $user->role = 'agronomist'; // Ou un autre statut temporaire
        // $user->professional_experience = $request->professional_experience;
        // $user->profile_picture = $profilePicturePath;
        // $user->identity_document = $identityDocumentPath;
        // $user->certificate = $certificatePath;
        // $user->save();

        // Rediriger avec un message de succès
        return redirect()->route('user.dashboard')->with('success', 'Votre demande a été soumise avec succès. Elle sera examinée par un administrateur.');
    }


    
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $user = User::findOrFail($id);
    
        // Vérifier si l'ancien mot de passe est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'L\'ancien mot de passe est incorrect.');
        }
    
        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->password);
        $user->save();
    
        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès !');
    }
    


    public function edit($id)
{
    $user = User::findOrFail($id);

    if (auth()->id() !== $user->id) {
        abort(403, 'Accès non autorisé.');
    }

    return view('user.edit_profile', compact('user'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    if (auth()->id() !== $user->id) {
        abort(403, 'Accès non autorisé.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'bio' => 'nullable|string|max:500',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'bio' => $request->bio,
    ]);

    return redirect()->route('user.profile', $user->id)->with('success', 'Profil mis à jour avec succès.');
}




    public function campaigns()
    {
        // Récupérer les campagnes paginées par 10
        $campaigns = Cagnotte::where('status', 'open')->latest()->paginate(10);

        return view('user.campaigns', compact('campaigns'));
    }

        public function showCampaign($id)
    {
        $campaign = Cagnotte::findOrFail($id);
        $project = Project::find($campaign->project_id);
        $agronome = User::find($campaign->user_id);

        return view('user.show_campaigns', compact('campaign', 'project', 'agronome'));
    }

        public function services()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(10);

        return view('user.services', compact('services'));
    }

        public function showService($id)
    {
        $service = Service::with('owner.user')->findOrFail($id);

        return view('user.show_service', compact('service'));
    }
 
    public function showProject($id)
{
    // Récupérer le projet
    $project = Project::findOrFail($id);

    // Récupérer le project owner associé au projet
    $projectOwner = $project->projectOwner; // La relation projectOwner dans le modèle Project

    // Récupérer l'agronome (user) à partir du projectOwner
    $agronome = $projectOwner ? $projectOwner->user : null; // On vérifie si le projectOwner existe

    // Récupérer toutes les campagnes associées à ce projet
    $campaigns = Cagnotte::where('project_id', $id)->get();

    // Retourner la vue avec les détails du projet et les campagnes associées
    return view('user.show_project', compact('project', 'agronome', 'campaigns'));
}

    
public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1|max:' . (Cagnotte::where('id', $request->cagnotte_id)->value('target_amount') - Cagnotte::where('id', $request->cagnotte_id)->value('collected_amount')),
        'payment_method' => 'required',
    ]);

    // Simuler un paiement via FedaPay
    $paymentSuccess = true; // À remplacer par l'intégration FedaPay

    if ($paymentSuccess) {
        // Enregistrer la contribution
        $contribution = Investment::create([
            'user_id' => auth()->id(),
            'cagnotte_id' => $request->cagnotte_id,
            'amount' => $request->amount,
            'status' => 'pending',
            'anonymat' => $request->has('anonymat') ? 'oui' : 'non',
        ]);

        // Enregistrer la transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'type' => 'investment',
            'amount' => $request->amount,
            'status' => 'completed',
            'description' => 'Contribution à la cagnotte ID #' . $request->cagnotte_id,
        ]);

        // Mettre à jour la cagnotte
        $cagnotte = Cagnotte::find($request->cagnotte_id);
        if ($cagnotte) {
            $cagnotte->collected_amount += $request->amount;
            $cagnotte->save();
        }

        // Mettre à jour le projet si lié
        if ($cagnotte && $cagnotte->project_id) {
            $project = Project::find($cagnotte->project_id);
            if ($project) {
                $project->current_amount += $request->amount;
                $project->save();
            }
        }

        return redirect()->back()->with('success', 'Votre contribution a été enregistrée avec succès !');
    }

    return redirect()->back()->with('error', 'Le paiement a échoué. Veuillez réessayer.');
}

    public function index()
    {
        $notifications = Auth::user()->notificationpv()->latest()->paginate(10);
        return view('user.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notificationpv::where('id', $id)->where('user_id', Auth::id())->first();
        
        if ($notification) {
            $notification->update(['lu' => 1]);
            return response()->json(['success' => true, 'message' => 'Notification marquée comme lue.']);
        }

        return response()->json(['success' => false, 'message' => 'Notification non trouvée.'], 404);
    }

    public function destroy($id)
    {
        $notification = Notificationpv::where('id', $id)->where('user_id', Auth::id())->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification supprimée.']);
        }

        return response()->json(['success' => false, 'message' => 'Notification non trouvée.'], 404);
    }

    public function showAgronome($id) 
{
    $agronome = ProjectOwner::with(['user', 'projects'])
        ->where('user_id', $id)
        ->firstOrFail();

    return view('user.show_agronome', compact('agronome'));
}




    public function showTransactions()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->get();

        return view('user.transaction', compact('transactions', 'user'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'numero' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        if ($request->amount > $user->wallet) {
            return back()->with('error', 'Montant supérieur à votre solde.');
        }

        Transaction::create([ 
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Déduire le montant du wallet ici si tu veux le faire immédiatement
        // $user->wallet -= $request->amount;
        // $user->save();

        return back()->with('success', 'Transaction en attente enregistrée.');
    }


}

