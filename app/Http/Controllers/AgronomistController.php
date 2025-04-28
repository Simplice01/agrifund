<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\Service;



class AgronomistController extends Controller
{
    // Dashboard agronome
    public function dashboard()
    {
        return view('user.dashboard');
    }

    // Afficher le formulaire de création de projet
    public function showCreateProjectForm()
    {
        return view('agronomist.create_project');
    }

        public function showAllProjects()
    {
        $projects = Project::where('status', 'approved')->get(); // Récupère uniquement les projets validés
        return view('agronomist.all_projects', compact('projects'));
    }


    // Créer un projet
    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'description' => 'required|string',
            'socio_economic_impact' => 'required|string',
        ]);

        Project::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'domain' => $request->domain,
            'description' => $request->description,
            'socio_economic_impact' => $request->socio_economic_impact,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Projet créé avec succès');
    }

    // Afficher tous les projets
    public function showProjects()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        return view('agronomist.projects', compact('projects'));
    }

    // Voir les détails d'un projet
    public function showProject($id)
    {
        $project = Project::findOrFail($id);
        return view('agronomist.show_project', compact('project'));
    }

    // Afficher le formulaire d'édition d'un projet
    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        
        // Vérifier si l'utilisateur est le propriétaire
        if (auth()->id() !== $project->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à modifier ce projet.');
        }

        return view('agronomist.edit_project', compact('project'));
    }

    // Mettre à jour un projet
    public function updateProject(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'domain' => 'required|string|max:255',
        'description' => 'required|string',
        'socio_economic_impact' => 'required|string',
    ]);

    $project = Project::findOrFail($id);
    
    // Vérifier si l'utilisateur est le propriétaire
    if (auth()->id() !== $project->user_id) {
        return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à modifier ce projet.');
    }

    $project->update([
        'name' => $request->name,
        'domain' => $request->domain,
        'description' => $request->description,
        'socio_economic_impact' => $request->socio_economic_impact,
    ]);

    return redirect()->route('agronomist.show_project', $id)->with('success', 'Projet mis à jour avec succès.');
}

// Supprimer un projet
public function deleteProject($id)
{
    $project = Project::findOrFail($id);
    
    // Vérifier si l'utilisateur est le propriétaire
    if (auth()->id() !== $project->user_id) {
        return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à supprimer ce projet.');
    }

    // Vérifier si le projet a des campagnes associées
    if ($project->campaigns()->exists()) {
        return redirect()->route('user.dashboard')->with('error', 'Vous ne pouvez pas supprimer un projet qui a des campagnes associées.');
    }

    $project->delete();
    return redirect()->route('user.dashboard')->with('success', 'Projet supprimé avec succès.');
}


    // Afficher le formulaire de création de campagne
    public function showCreateCampaignForm()
    {
        return view('agronomist.create_campaign');
    }

    // Créer une campagne
    public function storeCampaign(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Campaign::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Campagne créée avec succès');
    }


    // Afficher toutes les campagnes


    // Afficher toutes les campagnes
    public function showCampaigns()
{
    // Récupérer l'utilisateur connecté
    $user = auth()->user();

    // Vérifier si l'utilisateur a un abonnement actif
    $hasSubscription = $user->subscriptions()->where('end_date', '>', Carbon::now())->exists();

    // Récupérer les campagnes des utilisateurs ayant un abonnement actif
    $campaignsWithSubscription = Campaign::whereHas('project', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->whereHas('contributions', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->get();

    // Récupérer les campagnes des utilisateurs sans abonnement
    $campaignsWithoutSubscription = Campaign::whereHas('project', function ($query) use ($user) {
        $query->where('user_id', '!=', $user->id); // On récupère les campagnes des autres agronomes
    })
    ->get();

    // Combiner les deux listes : d'abord les campagnes avec abonnement, puis celles sans abonnement
    $campaigns = $campaignsWithSubscription->merge($campaignsWithoutSubscription);

    return view('agronomist.campaigns', compact('campaigns'));
}


    // Voir les détails d'une campagne
    public function showCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Vérifier si l'utilisateur est connecté
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }
    
        // Récupérer le solde du portefeuille de l'utilisateur
        $userWalletBalance = $user->wallet_balance ?? 0;
        return view('agronomist.show_campaign', compact('campaign', 'userWalletBalance'));
    }


    // Afficher le formulaire d'édition d'une campagne
    public function editCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Vérifier si l'utilisateur est le propriétaire du projet associé
        if (auth()->id() !== $campaign->project->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à modifier cette campagne.');
        }

        return view('agronomist.edit_campaign', compact('campaign'));
    }

    // Mettre à jour une campagne
    public function updateCampaign(Request $request, $id)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'goal_amount' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ]);

    $campaign = Campaign::findOrFail($id);

    // Vérifier si l'utilisateur est le propriétaire du projet associé
    if (auth()->id() !== $campaign->project->user_id) {
        return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à modifier cette campagne.');
    }

    // Empêcher la modification d'une campagne active
    if ($campaign->status === 'active') {
        return redirect()->route('user.dashboard')->with('error', 'Impossible de modifier une campagne active.');
    }

    $campaign->update([
        'title' => $request->title,
        'description' => $request->description,
        'goal_amount' => $request->goal_amount,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return redirect()->route('agronomist.show_campaign', $id)->with('success', 'Campagne mise à jour avec succès.');
}
// Supprimer une campagne (sauf si elle est active)
    public function deleteCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Vérifier si l'utilisateur est le propriétaire du projet associé
        if (auth()->id() !== $campaign->project->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette campagne.');
        }

        // Vérifier si la campagne est active
        if ($campaign->status === 'active') {
            return redirect()->route('user.dashboard')->with('error', 'Impossible de supprimer une campagne active.');
        }

        $campaign->delete();
        return redirect()->route('user.dashboard')->with('success', 'Campagne supprimée avec succès.');
    }

    public function listServices()
    {
        $services = Service::where('user_id', Auth::id())->get();
        return view('agronomist.services', compact('services'));
    }

        public function listProjects()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('agronomist.projects', compact('projects'));
    }

    public function listCampaigns()
    {
        // Récupérer les IDs des projets appartenant à l'utilisateur connecté
        $projectIds = Project::where('user_id', Auth::id())->pluck('id');
    
        // Récupérer les campagnes liées à ces projets
        $campaigns = Campaign::whereIn('project_id', $projectIds)->get();
    
        return view('agronomist.campaigns', compact('campaigns'));
    }
    // Afficher et gérer les services
    public function manageServices()
    {
        $services = Service::where('user_id', auth()->id())->get();
        return view('agronomist.manage_services', compact('services'));
    }

    // Afficher le formulaire de création de service
    public function createService()
    {
        return view('agronomist.create_service');
    }

    // Créer un service
        public function storeService(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'execution_time' => 'required|string',
            'conditions' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation des images
        ]);

        // Traitement des images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                // Stockage de l'image dans le dossier public/service_picture
                $path = $image->store('service_picture', 'public');
                $imagePaths[] = $path; // Ajoute le chemin de l'image au tableau
            }
        }

        // Création du service avec les données envoyées
        $service = Service::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'execution_time' => $request->execution_time,
            'conditions' => $request->conditions,
            'images' => $imagePaths ? json_encode($imagePaths) : null, // Enregistrement des chemins des images
            'status' => 'pending',
        ]);

        // Redirection avec un message de succès
        return redirect()->route('user.dashboard')->with('success', 'Service créé avec succès');
    }

    // Modifier un service
    public function editService($id)
    {
        $service = Service::findOrFail($id);
        return view('agronomist.edit_service', compact('service'));
    }

    // Mettre à jour un service
    public function updateService(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'execution_time' => 'required|string',
            'conditions' => 'required|string',
            'images' => 'nullable|array',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'execution_time' => $request->execution_time,
            'conditions' => $request->conditions,
            'images' => $request->images ? json_encode($request->images) : null,
        ]);

        return redirect()->route('agronomist.manage_services')->with('success', 'Service mis à jour avec succès');
    }

    // Supprimer un service
    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('agronomist.manage_services')->with('success', 'Service supprimé avec succès');
    }
}
