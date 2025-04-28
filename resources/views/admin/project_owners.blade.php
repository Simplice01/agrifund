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
        <h3 class="text-center text-success mb-4">📜 Liste des Propriétaires de Projet</h3>

        @if($owners->isEmpty())
            <p class="text-center text-muted">Aucun propriétaire trouvé.</p>
        @else
            <div class="table-responsive"> 
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color:#08090a;"> Nom</th>
                            <th style="color:#08090a;"> Email</th>
                            <th style="color:#08090a;"> Date de Naissance</th>
                            <th style="color:#08090a;"> Nationalité</th>
                            <th style="color:#08090a;"> Adresse</th>
                            <th style="color:#08090a;"> Statut</th>
                            <th style="color:#08090a;"> Pièce d'identité</th>
                            <th style="color:#08090a;"> Diplôme</th>
                            <th style="color:#08090a;">👁️</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($owners as $owner)
                            <tr>
                                <td>{{ $owner->nom }} {{ $owner->prenoms }}</td>
                                <td>{{ $owner->email }}</td>
                                <td>{{ $owner->birthday ? \Carbon\Carbon::parse($owner->birthday)->format('d/m/Y') : 'Non renseignée' }}</td>
                                <td>{{ $owner->nationalite ?? 'Non renseignée' }}</td>
                                <td>{{ $owner->adress ?? 'Non renseignée' }}</td>
                                <td>
                                    @if($owner->verification_status === 'verified')
                                        <span class="badge bg-success">Vérifié</span>
                                    @elseif($owner->verification_status === 'rejected')
                                        <span class="badge bg-danger">Rejeté</span>
                                    @else
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @endif
                                </td>
                                <td>
                                    @if($owner->identity_document)
                                        <a href="{{ asset('storage/' . $owner->identity_document) }}" target="_blank">Voir</a>
                                    @else
                                        Aucun
                                    @endif
                                </td>
                                <td>
                                    @if($owner->diplomedoc)
                                        <a href="{{ asset('storage/' . $owner->diplomedoc) }}" target="_blank">Voir</a>
                                    @else
                                        Aucun
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.show_project_owner', $owner->id) }}" class="btn btn-sm btn-info"> Afficher</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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
