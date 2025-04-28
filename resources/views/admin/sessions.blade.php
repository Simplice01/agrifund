@extends('layout.user', ['title' => 'Détails de la Campagne'])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 border-0">
        <h3 class=" text-center text-primary mb-4">
            <i class="fas fa-sign-in-alt"></i> 📅 Historique des Connexions
        </h3>

        @if($sessions->isEmpty())
            <p class="text-center text-muted">Aucune session enregistrée.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#️⃣</th>
                            <th> Utilisateur</th>
                            <th> Date & Heure</th>
                            <th> Adresse IP</th>
                            <th> User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $key => $session)
                            <tr>
                                <td class="fw-bold text-center">{{ $key + 1 }}</td>
                                <td>
                                    <i class="fas fa-user-circle text-info mr-2"></i> {{ $session->user ? $session->user->name : 'inconnu' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ \Carbon\Carbon::parse($session->last_activity)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>{{ $session->ip_address }}</td>
                                <td class="text-truncate" style="max-width: 250px;">
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $session->user_agent }}">
                                        <i class="fas fa-laptop text-success mr-2"></i>{{ Str::limit($session->user_agent, 50) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
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

        .table-bordered {
            border: 1px solid #dee2e6;
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
            padding: 6px 12px;
            font-weight: bold;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #333;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
