@extends('layout.user', ['title' => "Mon compte"])
@section('content')
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            confirmButtonText: 'Ok',
            background: '#f4f4f9'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}',
            confirmButtonText: 'Ok',
            background: '#f4f4f9'
        });
    </script>
@endif

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-primary">💼 Détails de l'Investissement</h3>

        <ul class="list-group mt-3">
            <li class="list-group-item"><strong>Investisseur :</strong> {{ $investment->investor->name }}</li>
            <li class="list-group-item"><strong>Projet :</strong> {{ $investment->project->title }}</li>
            <li class="list-group-item"><strong>Montant :</strong> {{ number_format($investment->amount, 2, ',', ' ') }} €</li>
            <li class="list-group-item"><strong>Statut :</strong> {{ ucfirst($investment->status) }}</li>
        </ul>

        <div class="text-center mt-4">
            <a href="{{ route('admin.investments') }}" class="btn btn-outline-primary">🔙 Retour</a>
        </div>
    </div>
</div>
@endsection
