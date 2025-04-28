<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;
use App\Models\User;
use App\Models\Wallet;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Tentative de connexion de l'utilisateur avec les informations fournies
        if (Auth::attempt($credentials)) {
            // // Enregistrer l'historique de connexion
            // LoginHistory::create([
            //     'user_id' => Auth::id(),
            //     'ip_address' => $request->ip(),
            //     'user_agent' => $request->header('User-Agent'),
            // ]);

            // // Mettre à jour la dernière connexion
            // Auth::user()->update(['last_login_at' => now()]);



            // Sinon, rediriger vers un autre tableau de bord ou page
            return redirect()->route('user.dashboard');
        }

        // return back()->withErrors(['email' => 'Invalid credentials']);
        return back()->with('error', 'Identifiants invalides. Veuillez réessayer.');

    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'investor', // Par défaut, l'utilisateur est un simple utilisateur
    ]);

    // Création de l'entrée dans la table wallet pour l'utilisateur
    Wallet::create([
        'user_id' => $user->id,      // Lier le wallet à l'utilisateur
        'balance' => 0,              // Initialiser avec un solde de 0
    ]);

    // Connexion immédiate de l'utilisateur après l'inscription
    Auth::login($user);

    // Redirection vers le tableau de bord en fonction du rôle
    return redirect()->route('user.dashboard');
}

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
