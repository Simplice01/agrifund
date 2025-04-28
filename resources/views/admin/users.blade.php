{{-- @extends('layout.app') --}}
@extends('layout.user',['title'=>"Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class=" text-center text-primary mb-4">👥 Gestion des Utilisateurs</h3>

        @if($users->isEmpty())
            <p class="text-center text-muted">Aucun utilisateur enregistré.</p>
        @else 
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Rechercher un client...">
                </div>
                
                <table id="users-table" class="table table-bordered table-hover">
                    <thead class="table-dark text-center " >
                        <tr>
                            <th >#️⃣</th>
                            <th style="color:#08090a;" > Nom</th>
                            <th style="color:#08090a;"> Email</th>
                            <th style="color:#08090a;"> Rôle</th>
                            {{-- <th style="color:#08090a;">📞 Téléphone</th> --}}
                            <th style="color:#08090a;"> Dernière Connexion</th>
                            <th style="color:#08090a;"> Pièce d'Identité</th>
                            <th style="color:#08090a;"> Créé le</th>
                            <th style="color:#08090a;"> Afficher</th>
                            <th style="color:#08090a;"> Modifier</th>
                            <th style="color:#08090a;">🗑️ Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr class="align-middle text-center">
                                <td class="fw-bold">{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                {{-- <td>{{ $user->phone ?? '🚫 Non renseigné' }}</td> --}}
                                <td>{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') : 'Jamais' }}</td>
                                <td>
                                    @if($user->identity_document)
                                        <a href="{{ asset('storage/' . $user->identity_document) }}" target="_blank" class="text-success">
                                            📄 Voir
                                        </a>
                                    @else
                                        <span class="text-danger">🚫 Aucun</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>

                                <!-- Bouton Afficher -->
                                <td>
                                    <a href="{{ route('admin.show_user', ['id' => $user->id]) }}" class="btn btn-sm btn-info">
                                        👁️
                                    </a>
                                </td>

                                <!-- Bouton Modifier -->
                                <td>
                                    <a href="{{ route('admin.edit_user', $user->id) }}" class="btn btn-sm btn-warning">
                                        ✏️
                                    </a>
                                </td>

                                <!-- Bouton Supprimer -->
                                <td>
                                    <form action="{{ route('admin.delete_user', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                ⬅️ Retour au Tableau de Bord
            </a>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script de recherche dynamique -->
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

        .search-input {
        width: 250px; /* Ajustez la largeur selon vos besoins */
        margin-right: auto;
        margin-left: auto;
        display: block;
    }
    </style>
@endsection


