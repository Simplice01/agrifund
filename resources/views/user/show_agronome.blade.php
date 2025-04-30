@extends('layout.user', ['title' => 'Profil Agronome'])

@section('content')
<div class="container py-5">
    <div class="card shadow p-4">
        <h3 class="text-primary mb-4">👨‍🌾 Profil du porteur de projet</h3>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nom :</strong> {{ $agronome->nom }}</p>
                <p><strong>Prénoms :</strong> {{ $agronome->prenoms }}</p>
                <p><strong>Nationalité :</strong> {{ $agronome->nationalite }}</p>
                <p><strong>Email :</strong> {{ $agronome->email }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($agronome->birthday)->format('d/m/Y') }}</p>
                <p><strong>Lieu de naissance :</strong> {{ $agronome->lieunaissance }}</p>
                <p><strong>Adresse :</strong> {{ $agronome->adress }}</p>
                <p><strong>Biographie :</strong><br> {!! nl2br(e($agronome->bio)) !!}</p>
            </div>
        </div>
    </div>
</div>
@endsection
