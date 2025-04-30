{{-- @extends('layout.user', ['title' => $service->title]) --}}
@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h4 class="text-center text-uppercase fw-bold text-primary">{{ $service->title }}</h4>
            <p class="text-center text-muted">Ajouté le {{ $service->created_at->format('d M Y') }}</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5 class="text-success fw-bold">Prix : {{ number_format($service->price, 2) }} FCFA</h5>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge 
                        {{ now()->diffInDays($service->created_at) < 10 ? 'bg-danger' : (now()->diffInDays($service->created_at) > 50 ? 'bg-warning' : 'bg-primary') }}">
                        {{ now()->diffInDays($service->created_at) < 10 ? 'Nouveau' : (now()->diffInDays($service->created_at) > 50 ? '★★★★★' : '★★★') }}
                    </span>
                </div>
            </div>

            <hr>

            <p class="lead text-dark">{{ $service->description }}</p>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5 class="text-muted">Proposé par : <span class="text-primary fw-bold">{{ $service->owner?->user?->name ?? 'Non défini' }}</span></h5>
                <a href="mailto:{{ $service->owner?->user?->email ?? 'Non défini' }}" class="btn btn-lg btn-success">
                    <i class="fas fa-envelope"></i> Contacter
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
