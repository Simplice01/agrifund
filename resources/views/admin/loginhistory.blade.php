@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="display-5 text-center text-primary mb-4">📅 Historique des Connexions</h1>

        @if($logins->isEmpty())
            <p class="text-center text-muted">Aucune connexion enregistrée.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#️⃣</th>
                            <th style="color:#08090a;"> Utilisateur</th>
                            <th style="color:#08090a;"> Date & Heure</th>
                            <th style="color:#08090a;"> Adresse IP</th>
                            <th style="color:#08090a;"> User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logins as $key => $login)
                            <tr>
                                <td class="fw-bold">{{ $key + 1 }}</td>
                                <td>{{ $login->user->name }}</td>
                                <td><span class="badge bg-info">{{ \Carbon\Carbon::parse($login->login_at)->format('d/m/Y H:i') }}</span></td>
                                <td>{{ $login->ip_address }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $login->user_agent }}</td>
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
