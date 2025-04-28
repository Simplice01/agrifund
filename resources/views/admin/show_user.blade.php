@extends('layout.user', ['title' => "Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-primary mb-4">📋 Détails de l'Utilisateur</h3>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>👤 Nom :</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>📧 Email :</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>📅 Inscrit le :</strong> {{ $user->created_at->format('d/m/Y') }}</li>
                   {{-- Affichage du rôle actuel --}}
<li class="list-group-item">
    <strong>📜 Rôle actuel :</strong> {{ ucfirst($user->role) ?? 'Utilisateur' }}
</li>

{{-- Formulaire de modification du rôle (visible uniquement pour l'admin) --}}
@if(auth()->user()->role === 'admin')
    <li class="list-group-item">
        <form action="{{ route('admin.updateUserRole', $user->id) }}" method="POST" class="row g-2 align-items-center">
            @csrf

            <div class="col-md-8">
                <label for="role" class="form-label">Changer le rôle :</label>
                <select name="role" id="role" class="form-select">
                    <option value="investor" {{ $user->role === 'investor' ? 'selected' : '' }}>Investisseur</option>
                    <option value="Project_owner" {{ $user->role === 'Project_owner' ? 'selected' : '' }}>Agronome</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div>

            <div class="col-md-4 d-grid">
                <button type="submit" class="btn btn-success mt-4">Mettre à jour</button>
            </div>
        </form>
    </li>
@endif

                                    </ul>
            </div>

            @if($user->role === 'admin')
                <div class="col-md-6">
                    <h4 class="text-danger">⚡ Administrateur</h4>
                    <p>Vous avez un accès complet au système.</p>
                </div>
            @endif

            @if($user->role === 'Project_owner' && $user->projectOwner)
                <div class="col-md-6">
                    <h4 class="text-success">👨‍🌾 Agronome : {{ $user->name }}</h4>
                    <p><strong>Statut de l'agronome : </strong>{{ $user->projectOwner->verification_status ?? 'Non vérifié' }}</p>
                </div>
            @endif
        </div>

        {{-- ✅ AFFICHAGE DES PROJETS --}}
        <h4 class="text-success mt-4">📌 Projets</h4>
        @if(auth()->user()->role === 'admin' && $projects->isNotEmpty())
            @foreach($projects as $project)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Projet :</strong> {{ $project->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $project->description }}</li>
                    <li class="list-group-item"><strong>💰 Objectif :</strong> {{ number_format($project->goal_amount, 2) }} €</li>
                </ul>
            @endforeach
        @elseif($user->projectOwner && $user->projectOwner->projects->isNotEmpty())
            @foreach($user->projectOwner->projects as $project)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Projet :</strong> {{ $project->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $project->description }}</li>
                    <li class="list-group-item"><strong>💰 Objectif :</strong> {{ number_format($project->goal_amount, 2) }} €</li>
                </ul>
            @endforeach
        @else
            <p class="text-muted">Aucun projet disponible.</p>
        @endif

        {{-- ✅ AFFICHAGE DES SERVICES --}}
        <h4 class="text-success mt-4">🔧 Services</h4>
        @if(auth()->user()->role === 'admin' && $services->isNotEmpty())
            @foreach($services as $service)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Service :</strong> {{ $service->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $service->description }}</li>
                    <li class="list-group-item"><strong>💰 Prix :</strong> {{ number_format($service->price, 2) }} €</li>
                </ul>
            @endforeach
        @elseif($user->projectOwner && $user->projectOwner->services->isNotEmpty())
            @foreach($user->projectOwner->services as $service)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Service :</strong> {{ $service->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $service->description }}</li>
                    <li class="list-group-item"><strong>💰 Prix :</strong> {{ number_format($service->price, 2) }} €</li>
                </ul>
            @endforeach
        @else
            <p class="text-muted">Aucun service disponible.</p>
        @endif

        {{-- ✅ AFFICHAGE DES CAMPAGNES --}}
        <h4 class="text-success mt-4">📢 Campagnes</h4>
        @if(auth()->user()->role === 'admin' && $campaigns->isNotEmpty())
            @foreach($campaigns as $campaign)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Campagne :</strong> {{ $campaign->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $campaign->description }}</li>
                    <li class="list-group-item"><strong>💰 Budget :</strong> {{ number_format($campaign->target_amount, 2) }} €</li>
                </ul>
            @endforeach
        @elseif($user->projectOwner && $user->projectOwner->campaigns->isNotEmpty())
            @foreach($user->projectOwner->campaigns as $campaign)
                <ul class="list-group mb-2">
                    <li class="list-group-item"><strong>📛 Campagne :</strong> {{ $campaign->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $campaign->description }}</li>
                    <li class="list-group-item"><strong>💰 Budget :</strong> {{ number_format($campaign->target_amount, 2) }} €</li>
                </ul>
            @endforeach
        @else
            <p class="text-muted">Aucune campagne disponible.</p>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">⬅️ Retour</a>
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
