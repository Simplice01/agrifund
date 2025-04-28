@extends('layout.user', ['title' => "Détails du Service"])

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
        <h4 class="text-center text-primary mb-4">📌 Liste des Transactions</h4>

        @if($transactions->isEmpty())
            <p class="text-center text-muted">Aucune transaction trouvée.</p>
        @else
        <div class="mb-4">
            <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
        </div>
    
            <div class="table-responsive">
                <table   id="users-table"  class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color:#08090a;">👤 Utilisateur</th>
                            <th style="color:#08090a;">🔄 Type</th>
                            <th style="color:#08090a;">💰 Montant</th>
                            <th style="color:#08090a;">📊 Statut</th>
                            <th style="color:#08090a;">⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ number_format($transaction->amount, 2) }} €</td>
                                <td>
                                    <span class="badge {{ $transaction->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.show_transaction', $transaction->id) }}" class="btn btn-sm btn-warning">👁️ Voir</a>
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
