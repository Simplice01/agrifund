<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{

        public function showAll()
    {
        $services = Service::where('status', 'approved')->get(); // On récupère uniquement les services validés
        return view('service.all_services', compact('services'));
    }


    public function list()
    {
        $services = Service::where('status', 'approved')->get();
        return view('service.list', compact('services'));
    }

        public function details($id)
    {
        $service = Service::findOrFail($id);
        return view('service.details', compact('service'));
    }

        public function updateServiceStatus(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->status = $request->status;
        $service->save();

        return redirect()->back()->with('success', 'Statut du service mis à jour avec succès.');
    }


    public function edit($id)
    {
        $service = Service::findOrFail($id);

        // Vérification si l'utilisateur est le propriétaire ou un administrateur
        if (auth()->id() !== $service->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        return view('agronomist.edit_service', compact('service'));
    }

    // Mettre à jour le service
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Vérification si l'utilisateur est le propriétaire ou un administrateur
        if (auth()->id() !== $service->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'execution_time' => 'nullable|string',
            'conditions' => 'nullable|string',
            // Validation des images si nécessaire
        ]);

        $service->update($request->all());

        return redirect()->route('service.details', $service->id)->with('success', 'Service mis à jour avec succès.');
    }

    // Supprimer un service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Vérification si l'utilisateur est le propriétaire ou un administrateur
        if (auth()->id() !== $service->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        $service->delete();

        return redirect()->route('all_services')->with('success', 'Service supprimé avec succès.');
    }
}
