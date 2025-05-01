{{-- @extends('layout.user', ['title' => 'Profil Agronome']) --}}
@extends('layout.app')
{{-- @extends('layout.user', ['title' => 'Profil Agronome']) --}}

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow p-4 w-100" style="max-width: 900px; border-radius: 20px;">
        <div class="text-center mb-4">
            @if($agronome->identity_document) 
                <img src="{{ asset('storage/' . $agronome->identity_document) }}" 
                     alt="Photo de profil" 
                     class="rounded-circle shadow" 
                     style="width: 150px; height: 150px; object-fit: cover;">
            @else
                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center shadow" 
                     style="width: 150px; height: 150px; font-size: 60px; color: white;">
                    <i class="bi bi-person-fill"></i>
                </div>
            @endif

            <h3 class="mt-3 text-primary">{{ $agronome->nom }} {{ $agronome->prenoms }}</h3>
            
            @if($agronome->bio)
                <div class="mt-3">
                    <h5 class="text-dark fw-bold">Biographie</h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $agronome->bio }}</p>
                </div>
            @endif
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong> Nationalité :</strong> {{ $agronome->nationalite }}</p>
                <p><strong> Date de naissance :</strong> {{ \Carbon\Carbon::parse($agronome->birthday)->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong> Lieu de naissance :</strong> {{ $agronome->lieunaissance }}</p>
                <p><strong> Adresse :</strong> {{ $agronome->adress }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .card {
        background: linear-gradient(to bottom right, #ffffff, #f0f0f5);
    }
    strong {
        color: #444;
    }
    p {
        font-size: 16px;
        line-height: 1.6;
    }
    h5 {
        color: #555;
    }
</style>
@endsection
