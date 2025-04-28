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
        <h3 class="text-center text-primary mb-4">💼 Liste des Portefeuilles</h3>

        @if($wallets->isEmpty())
            <p class="text-center text-muted">Aucun portefeuille trouvé.</p>
        @else
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Rechercher un client...">
                </div>
                
                <table id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color:#08090a;"> Utilisateur</th>
                            <th style="color:#08090a;"> Solde</th>
                            <th style="color:#08090a;"> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $wallet)
                            <tr>
                                <td>{{ $wallet->user->name }}</td>
                                <td>{{ number_format($wallet->balance, 2) }} €</td>
                                <td>
                                    <a href="{{ route('admin.show_wallet', $wallet->id) }}" class="btn btn-sm btn-warning">👁️ Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">⬅️ Retour</a>
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
