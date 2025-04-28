<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{


    
    

        public function showAllCampaigns()
    {
        $campaigns = Campaign::where('status', 'active')->get(); // Récupère uniquement les campagnes actives
        return view('agronomist.all_campaigns', compact('campaigns'));
    }



    public function contribute(Request $request, $campaignId)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'payment_method' => 'required|string|in:wallet,other', // wallet or other
    ]);

    $campaign = Campaign::findOrFail($campaignId);
    $amount = $request->input('amount');
    $paymentMethod = $request->input('payment_method');
    $user = auth()->user();

    if ($paymentMethod === 'wallet') {
        // Vérifier si l'utilisateur a assez d'argent dans son portefeuille
        if ($user->wallet_balance < $amount) {
            return back()->with('error', 'Solde insuffisant dans votre portefeuille.');
        }

        // Déduire le montant du portefeuille
        $user->deductFromWallet($amount);

        // Enregistrer la contribution
        $campaign->contributions()->create([
            'user_id' => $user->id,
            'amount' => $amount,
        ]);

        return back()->with('success', 'Contribution réussie.');
    } elseif ($paymentMethod === 'other') {
        // Ajouter ici la logique pour le paiement avec un autre moyen (carte bancaire, PayPal, etc.)
        // Par exemple, rediriger vers une page de paiement tiers
        return redirect()->route('payment.page', ['amount' => $amount, 'campaignId' => $campaignId]);
    }
}

    // Méthode pour rediriger l'utilisateur vers FedaPay
    public function redirectToFedaPay($campaignId, $amount)
    {
        // Logique de redirection vers FedaPay (exemple fictif)
        // Par exemple, vous utiliseriez l'API de FedaPay ici pour créer une demande de paiement et récupérer un lien.
        
        // Exemple de lien fictif vers FedaPay
        $paymentLink = 'https://www.fedapay.com/pay?amount=' . $amount . '&campaign_id=' . $campaignId;

        return redirect()->to($paymentLink);
    }


    //     public function contribute(Request $request, $id)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     $campaign = Campaign::findOrFail($id);

    //     Contribution::create([
    //         'user_id' => auth()->id(),
    //         'campaign_id' => $campaign->id,
    //         'amount' => $request->amount,
    //     ]);

    //     $campaign->increment('current_amount', $request->amount);

    //     return redirect()->route('agronomist.show_campaign', $campaign->id)->with('success', 'Merci pour votre contribution !');
    // }
}
