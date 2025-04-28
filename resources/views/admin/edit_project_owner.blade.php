@extends('layout.admin', ['title' => "Modifier le Propriétaire"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-warning mb-4">✏️ Modifier le Propriétaire</h3>

        <form action="{{ route('admin.update_project_owner', $owner->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Statut de vérification</label>
                <select name="verification_status" class="form-select">
                    <option value="en attente" {{ $owner->verification_status == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="validé" {{ $owner->verification_status == 'validé' ? 'selected' : '' }}>Validé</option>
                    <option value="refusé" {{ $owner->verification_status == 'refusé' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Justification</label>
                <input type="text" name="justification_document" class="form-control" value="{{ $owner->justification_document }}">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">✅ Enregistrer</button>
                <a href="{{ route('admin.project_owners') }}" class="btn btn-secondary">⬅️ Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
