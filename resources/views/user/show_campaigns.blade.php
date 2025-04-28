@extends('layout.user',['title'=>"Mon compte"])


@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="row g-0">
            <!-- Image -->
            <div class="col-md-5">
              <img src="{{ asset('storage/'.$campaign->thumbnail) }}" class="img-fluid rounded-start w-100 h-50" style="object-fit: cover;padding:15px;" alt="{{ $campaign->title }}">
              <div style="padding:15px;" class="mt-4">
                <h5 class="fw-bold text-dark">💸 Contribuer à cette campagne</h5>
                <form action="{{ route('contribute.store') }}" method="POST" id="contributionForm">
                    @csrf
                    <input type="hidden" name="cagnotte_id" value="{{ $campaign->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="anonymat" id="anonymatHidden" value="0">
                
                    <!-- Montant -->
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-bold">Montant (€)</label>
                        <input type="number" class="form-control" id="amount" name="amount" required min="1"
                            max="{{ $campaign->target_amount - $campaign->collected_amount }}">
                        <small class="text-muted">Le montant ne doit pas dépasser {{ number_format($campaign->target_amount - $campaign->collected_amount, 2) }} €.</small>
                    </div>
            
                    <!-- Anonymat -->
                   <!-- Anonymat -->
                    <div class="form-check mb-3">
                        <input type="hidden" name="anonymat" value="non"> <!-- Valeur par défaut -->
                        <input class="form-check-input" type="checkbox" name="anonymat" id="anonymat" value="oui">
                        <label class="form-check-label" for="anonymat">Contribuer de manière anonyme</label>
                    </div>

                
                    <!-- Choix du réseau -->
                    <div class="mb-3">
                        <label for="network" class="form-label fw-bold">Choisissez votre réseau</label>
                        <select class="form-control" id="network">
                            <option value="">Sélectionnez un réseau</option>
                            <option value="MTN">MTN</option>
                            <option value="MOOV">MOOV</option>
                            <option value="CELTIIS">CELTIIS</option>
                        </select>
                    </div>
                
                    <!-- Numéro de téléphone -->
                    <div class="mb-3">
                        <label for="phone_number" class="form-label fw-bold">Numéro de téléphone</label>
                        <input type="text" class="form-control" id="phone_number" name="payment_method"
                            placeholder="Ex: +229XXXXXXXX" required>
                    </div>
                
                    <!-- Bouton de soumission -->
                    <button type="submit" class="btn btn-primary w-100">💳 Contribuer</button>
                </form>
                            </div>
            
            </div>
            <!-- Contenu -->
            <div class="col-md-7">
                <div class="card-body p-5">
                    <h4 class="fw-bold text-primary text-uppercase">{{ $campaign->title }}</h4>
                    <p class="text-muted fs-5">{{ $campaign->description }}</p>
                    <p class="text-secondary">🗓 Publié le : {{ $campaign->created_at->format('d M Y') }}</p>
                    <p class="fs-4 text-success">🎯 Objectif : {{ number_format($campaign->target_amount, 2) }} €</p>
                    <p class="fs-4 text-danger">💰 Collecté : {{ number_format($campaign->collected_amount, 2) }} €</p>

                    <!-- Barre de progression -->
                    @php
                        $progress = $campaign->target_amount > 0 ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                    @endphp
                    <div class="progress mb-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ round($progress, 2) }}%
                        </div>
                    </div>

                    <div class="mb-4">
                        <strong class="text-dark">👨‍🌾 Agronome : </strong> 
                        <span class="text-primary fw-bold">{{ $agronome->name ?? 'Inconnu' }}</span>
                    </div>

                    <div class="d-flex gap-3">
                        {{-- <a href="#" class="btn btn-lg btn-primary">💰 Contribuer</a> --}}
                        {{-- {{ route('user.show_project', ['id' => $project->id]) }} --}}
                        <a href="{{ route('user.show_project', $campaign->project_id) }}" class="btn btn-lg btn-outline-dark">📌 Voir le Projet</a>
                    </div>
                </div>
            </div>
        </div>
   


<!-- Formulaire de contribution -->

</div>
</div>

@endsection

@section('styles')
<style>
    body {
        background: #f5f5f5;
    }
    .card {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.02);
    }
    .btn-primary {
        background-color: #FFD700;
        border-color: #FFD700;
        color: #000;
    }
    .btn-primary:hover {
        background-color: #FFC107;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    .form-check-input {
        transform: scale(1.2);
        margin-right: 8px;
    }
    .btn-primary {
        background-color: #FFD700;
        border: none;
    }
    .btn-primary:hover {
        background-color: #FFC107;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let anonymatCheckbox = document.getElementById("anonymatCheckbox");
        let anonymatHidden = document.getElementById("anonymatHidden");
        let networkSelect = document.getElementById("network");
        let phoneInput = document.getElementById("phone_number");
    
        // Gestion de l'anonymat
        anonymatCheckbox.addEventListener("change", function () {
            anonymatHidden.value = this.checked ? "1" : "0";
        });
    
        // Mise à jour du placeholder du numéro en fonction du réseau choisi
        networkSelect.addEventListener("change", function () {
            let prefix = "";
    
            switch (this.value) {
                case "MTN":
                    prefix = "+229 90"; // Exemple pour MTN
                    break;
                case "MOOV":
                    prefix = "+229 95"; // Exemple pour MOOV
                    break;
                case "CELTIIS":
                    prefix = "+229 96"; // Exemple pour CELTIIS
                    break;
            }
    
            phoneInput.value = prefix;
        });
    });
    </script>
    
@endsection
