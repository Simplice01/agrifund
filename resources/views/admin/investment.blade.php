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
        <h3 class="text-center text-success mb-4">💰 Gestion des Investissements</h3>

        @if($investments->isEmpty())
            <p class="text-center text-muted">Aucun investissement disponible.</p>
        @else
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color:#08090a;"> Investisseur</th>
                            <th style="color:#08090a;"> Projet</th>
                            <th style="color:#08090a;"> Montant</th>
                            <th style="color:#08090a;"> Statut</th>
                            <th style="color:#08090a;">👁️ </th>
                            {{-- <th style="color:#08090a;">✏️ Modifier</th>
                            <th style="color:#08090a;">❌ Supprimer</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($investments as $investment)
                            <tr>
                                <td>{{ $investment->investor->name }}</td>
                                <td>{{ $investment->project->title }}</td>
                                <td>{{ number_format($investment->amount, 2, ',', ' ') }} €</td>
                                <td>
                                    <span class="badge {{ $investment->status == 'validé' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($investment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.show_investment', $investment->id) }}" class="btn btn-info btn-sm">👁️ Afficher</a>
                                </td>
                                {{-- <td>
                                    <a href="{{ route('edit_investment', $investment->id) }}" class="btn btn-primary btn-sm">✏️ Modifier</a>
                                </td>
                                <td>
                                    <form action="{{ route('delete_investment', $investment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">❌ Supprimer</button>
                                    </form>
                                </td> --}}
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
