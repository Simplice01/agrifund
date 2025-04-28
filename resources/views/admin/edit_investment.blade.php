@extends('layout.user',['title'=>"Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-warning">✏️ Modifier l'Investissement</h3>

        <form action="{{ route('update_investment', $investment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Montant (€)</label>
                <input type="number" name="amount" value="{{ $investment->amount }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="status" class="form-control">
                    <option value="validé" {{ $investment->status == 'validé' ? 'selected' : '' }}>Validé</option>
                    <option value="en attente" {{ $investment->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">✅ Enregistrer</button>
            <a href="{{ route('investments') }}" class="btn btn-secondary">❌ Annuler</a>
        </form>
    </div>
</div>
@endsection
