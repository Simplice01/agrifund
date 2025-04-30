{{-- @extends('layout.user', ['title' => "Mon compte"]) --}}
@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="row g-0">
            <!-- Image -->
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $campaign->thumbnail) }}" class="img-fluid rounded-start w-100 h-50" style="object-fit: cover; padding: 15px;" alt="{{ $campaign->title }}">
            </div>

            <!-- Contenu -->
            <div class="col-md-7">
                <div class="card-body p-5">
                    <h4 class="fw-bold text-primary text-uppercase">{{ $campaign->title }}</h4>
                    <p class="text-muted fs-5">{{ $campaign->description }}</p>
                    <span style="padding: 1px;"></span>
                    <p class="text-secondary">🗓 Publié le : {{ $campaign->created_at->format('d M Y') }}</p>
                    <span style="padding: 1px;"></span>
                    <p class="fs-4 text-success">🎯 Objectif : {{ number_format($campaign->target_amount, 2) }} €</p>
                    <span style="padding: 1px;"></span>
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

                    {{-- <div class="mb-4">
                        <strong class="text-dark">👨‍🌾 Agronome : </strong> 
                        <span class="text-primary fw-bold">{{ $agronome->name ?? 'Inconnu' }}</span>
                        <span class="text-primary fw-bold">{{ optional($campaign->project->user)->name ?? 'Inconnu' }}</span>
                    </div> --}}

                    <div class="d-flex gap-4">
                        <a href="{{ route('user.show_project', $campaign->project_id) }}" class="btn btn-lg btn-outline-dark">📌 Voir le Projet</a>
                        <span style="padding: 10px;"></span>
                        <a href="{{ route('contribute.form', ['id' => $campaign->id]) }}" class="btn btn-lg btn-primary">💰 Contribuer</a>
                    </div>
                </div>
            </div>
        </div>
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
</style>
@endsection
