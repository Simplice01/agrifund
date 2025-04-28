@extends('layout.user', ['title' => "Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-info mb-4">💰 Détails du Portefeuille</h3>

        <ul class="list-group">
            <li class="list-group-item"><strong>👤 Utilisateur :</strong> {{ $wallet->user->name }}</li>
            <li class="list-group-item"><strong>📧 Email :</strong> {{ $wallet->user->email }}</li>
            <li class="list-group-item"><strong>💰 Solde :</strong> {{ number_format($wallet->balance, 2) }} €</li>
        </ul>

        <div class="text-center mt-4">
            <a href="{{ route('admin.wallets') }}" class="btn btn-outline-info">⬅️ Retour</a>
        </div>
    </div>
</div>
@endsection
