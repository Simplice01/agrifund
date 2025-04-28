@extends('layout.user',['title'=>"Mon compte"])

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
        <h3 class=" text-center text-primary mb-4">📢 Gestion des Campagnes</h3>

        @if($campaigns->isEmpty())
            <p class="text-center text-muted">Aucune campagne disponible.</p>
        @else
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color:#08090a;"> Titre</th>
                            <th style="color:#08090a;"> Projet</th>
                            <th style="color:#08090a;"> Montant Objectif (€)</th>
                            <th style="color:#08090a;"> Montant Actuel (€)</th>
                            <th style="color:#08090a;"> date de fin</th>
                            <th style="color:#08090a;"> Statut</th>
                            <th style="color:#08090a;"> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                            <tr>
                                <td class="fw-bold">{{ $campaign->title }}</td>
                                <td>{{ $campaign->project->name }}</td>
                                <td><span class="badge bg-success">{{ number_format($campaign->target_amount, 2) }} €</span></td>
                                <td><span class="badge bg-info">{{ number_format($campaign->collected_amount, 2) }} €</span></td>
                                <td>
                                    <span class="badge {{ \Carbon\Carbon::parse($campaign->date_fin)->isFuture() ? 'bg-danger' : 'bg-info' }}">
                                        {{ \Carbon\Carbon::parse($campaign->date_fin)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                
                                
                                <td>
                                    @if($campaign->status == 'pending')
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @elseif($campaign->status == 'open')
                                        <span class="badge bg-success">En cours</span>
                                    @elseif($campaign->status == 'completed')
                                    <span class="badge bg-success">Complet</span>
                                   
                                    @else
                                        <span class="badge bg-danger">Rejetée</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.show_campaign', $campaign->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Afficher
                                    </a>
                                    {{-- <form action="{{ route('delete_campaign', $campaign->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette campagne ?')">
                                            <i class="fas fa-trash"></i> Supprimer
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
