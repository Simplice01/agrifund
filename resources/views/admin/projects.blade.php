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
    <div class="card shadow-lm p-4">
        <h3 class=" text-center text-success mb-4">📌 Gestion des Projets</h3>

        @if($projects->isEmpty())
            <p class="text-center text-muted">Aucun projet disponible.</p>
        @else
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-bordered table-hover text-center">
                    <thead class="table-success">
                        <tr>
                            <th> Titre</th>
                            <th> Description</th>
                            <th> Montant</th>
                            <th> Montant obtenu</th>
                            <th> Statut</th>
                            <th>👁️ </th>
                            {{-- <th>✏️ Modifier</th>
                            <th>❌ Supprimer</th> --}}
                        </tr>
                    </thead>

                    <tbody class="align-middle">
                        @foreach($projects as $project)
                            <tr>
                                <td class="fw-bold">{{ $project->title }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $project->description }}</td>
                                <td><strong>{{ number_format($project->goal_amount, 0, ',', ' ') }} FCFA</strong></td>
                                <td><strong class="text-success">{{ number_format($project->current_amount, 0, ',', ' ') }} FCFA</strong></td>
                                <td>
                                    <span class="badge {{ $project->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <!-- Bouton Afficher -->
                                <td>
                                    <a href="{{ route('admin.show_project', $project->id) }}" class="btn btn-sm btn-info">
                                         Afficher
                                    </a>
                                </td>
                                <!-- Bouton Modifier -->
                                {{-- <td>
                                    <a href="{{ route('edit_project', $project->id) }}" class="btn btn-sm btn-warning">
                                         Modifier
                                    </a>
                                </td>
                                <!-- Bouton Supprimer -->
                                <td>
                                    <form action="{{ route('delete_project', $project->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                             Supprimer
                                        </button>
                                    </form>
                                </td> --}}
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
