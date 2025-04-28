@extends('layout.user', ['title' => "Détails du Service"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="display-5 text-center text-primary mb-4">📜 Liste des Abonnements</h1>

        @if($subscriptions->isEmpty())
            <p class="text-center text-muted">Aucun abonnement actif.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>👤 Utilisateur</th>
                            <th>📌 Type</th>
                            <th>📆 Début</th>
                            <th>⏳ Expiration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $key => $subscription)
                            <tr>
                                <td class="fw-bold">{{ $key + 1 }}</td>
                                <td>{{ $subscription->user->name }}</td>
                                <td>
                                    <span class="badge {{ $subscription->plan == 'Premium' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($subscription->plan) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y') }}
                                    @if(\Carbon\Carbon::parse($subscription->end_date)->isPast())
                                        <span class="text-danger">(Expiré)</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Retour au Tableau de Bord
            </a>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-dark {
            background-color: #343a40;
            color: #fff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .badge {
            font-size: 14px;
            padding: 6px 10px;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #333;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endsection
