@extends('layout.user', ['title' => "Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-success mb-4">👤 Détails du Propriétaire</h3>

        <ul class="list-group">
            <li class="list-group-item"><strong>👤 Nom :</strong> {{ $owner->nom }} {{ $owner->prenoms }}</li>
            <li class="list-group-item"><strong>📧 Email :</strong> {{ $owner->email }}</li>
            <li class="list-group-item"><strong>🎂 Date de naissance :</strong> {{ $owner->birthday ? \Carbon\Carbon::parse($owner->birthday)->format('d/m/Y') : 'Non renseignée' }}</li>
            <li class="list-group-item"><strong>🌍 Nationalité :</strong> {{ $owner->nationalite ?? 'Non renseignée' }}</li>
            <li class="list-group-item"><strong>📍 Lieu de naissance :</strong> {{ $owner->lieunaissance ?? 'Non renseigné' }}</li>
            <li class="list-group-item"><strong>🏠 Adresse :</strong> {{ $owner->adress ?? 'Non renseignée' }}</li>
            <li class="list-group-item">
                <strong>📜 Statut :</strong>
                <span class="badge 
                    @if($owner->verification_status == 'verified') bg-success 
                    @elseif($owner->verification_status == 'rejected') bg-danger 
                    @else bg-warning text-dark 
                    @endif">
                    {{ ucfirst($owner->verification_status) }}
                </span>
            </li>
            <li class="list-group-item"><strong>📎 Pièce d'identité :</strong>
                @if($owner->identity_document)
                    <a href="{{ asset('storage/' . $owner->identity_document) }}" target="_blank">Voir</a>
                @else
                    Aucune
                @endif
            </li>
            <li class="list-group-item"><strong>🎓 Diplôme :</strong>
                @if($owner->diplomedoc)
                    <a href="{{ asset('storage/' . $owner->diplomedoc) }}" target="_blank">Voir</a>
                @else
                    Aucun
                @endif
            </li>
            <li class="list-group-item"><strong>✅ Confirmation :</strong>
                {{ $owner->confirmation ? 'Oui' : 'Non' }}
            </li>
        </ul>

        @if(auth()->user()->role === 'admin')
        <!-- Formulaire de modification du statut et saisie de notification -->
        <form action="{{ route('admin.updateOwnerStatus', $owner->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <strong>📊 Modifier le Statut :</strong>
                    <select name="verification_status" class="form-select">
                        <option value="pending" {{ $owner->verification_status == 'pending' ? 'selected' : '' }}>🕒 En attente</option>
                        <option value="verified" {{ $owner->verification_status == 'verified' ? 'selected' : '' }}>✅ Vérifié</option>
                        <option value="rejected" {{ $owner->verification_status == 'rejected' ? 'selected' : '' }}>❌ Rejeté</option>
                    </select>
                </div>
                <div class="col-md-12 mt-3">
                    <strong>📢 Notification :</strong>
                    <textarea name="notification_message" class="form-control" placeholder="Entrez votre message de notification..." required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Mettre à jour et envoyer la notification</button>
        </form>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('admin.project_owners') }}" class="btn btn-outline-success">⬅️ Retour</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

@if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            timer: 3000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            timer: 3000
        });
@endif
</script>
@endsection
