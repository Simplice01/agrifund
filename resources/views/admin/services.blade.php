@extends('layout.user', ['title' => "Mon compte"])

@section('content')
<style>
            .search-input {
        width: 250px; /* Ajustez la largeur selon vos besoins */
        margin-right: auto;
        margin-left: auto;
        display: block;
    }
</style>
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-success mb-4">🛎️ Gestion des Services</h3>

        @if($services->isEmpty())
            <p class="text-center text-muted">Aucun service disponible.</p>
        @else
            <div class="table-responsive">
               
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr style="color:#08090a;">
                            <th style="color:#08090a;"> Agronome</th>
                            <th style="color:#08090a;"> Titre</th>
                            <th style="color:#08090a;"> Description</th>
                            <th style="color:#08090a;"> Prix</th>
                            <th style="color:#08090a;"> Statut</th>
                            <th style="color:#08090a;"> Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <!-- Vérification de la relation pour afficher le nom de l'utilisateur -->
                                <td class="fw-bold">
                                    @if($service->owner && $service->owner->user)
                                        {{ $service->owner->user->name }}
                                    @else
                                        <span class="text-muted">Non attribué</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $service->title }}</td>
                                <td class="text-truncate" style="max-width: 250px;">{{ $service->description }}</td>
                                <td>{{ number_format($service->price, 2, ',', ' ') }} €</td>
                                <td>
                                    <span class="badge {{ $service->status == 'Disponible' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $service->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.show_service', $service->id) }}" class="btn btn-sm btn-dark">
                                        👁️ 
                                    </a>
                                    {{-- <a href="{{ route('edit_service', $service->id) }}" class="btn btn-sm btn-warning">
                                        ✏️ 
                                    </a>
                                    <form action="{{ route('delete_service', $service->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            ❌ Supprimer
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-success">
                <i class="fas fa-arrow-left"></i> Retour au Tableau de Bord
            </a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
       $('#search').on('keyup', function() {
           var searchValue = $(this).val().toLowerCase();
           $('#users-table tbody tr').filter(function() {
               $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1)
           });
       });
   });
</script>
@endsection

@section('styles')
    <style>
        /* Table Styles */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-dark {
            background-color: #08090a;
            color: white;
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

        /* Buttons */
        .btn-warning, .btn-danger {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-sm {
            padding: 3px 7px;
        }

        /* Back Button */
        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
            font-weight: bold;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        /* Page Title */
        h3 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #333;
        }
    </style>
@endsection
