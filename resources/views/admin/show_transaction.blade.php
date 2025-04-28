@extends('layout.user', ['title' => "Détails de la Transaction"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h4 class="text-center text-info mb-4">💳 Détails de la Transaction</h4>

        <ul class="list-group">
            <li class="list-group-item"><strong>👤 Utilisateur :</strong> {{ $transaction->user->name }}</li>
            <li class="list-group-item"><strong>📧 Email :</strong> {{ $transaction->user->email }}</li>
            <li class="list-group-item"><strong>🔄 Type :</strong> {{ ucfirst($transaction->type) }}</li>
            <li class="list-group-item"><strong>💰 Montant :</strong> {{ number_format($transaction->amount, 2) }} €</li>
            <li class="list-group-item">
                <strong>📊 Statut :</strong>
                <span class="badge {{ $transaction->status == 'validée' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </li>
        </ul>

        <!-- Formulaire pour changer le statut -->
        @if($transaction->status != 'completed')
        <form action="{{ route('transaction.updateStatus', $transaction->id) }}" method="POST" class="mt-4">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="status">Changer le statut :</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                </select>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-outline-success">Mettre à jour</button>
            </div>
        </form>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('admin.transactions') }}" class="btn btn-outline-info">⬅️ Retour</a>
        </div>
    </div>
</div>
@endsection
