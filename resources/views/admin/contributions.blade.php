@extends('layout.user',['title'=>"Mon compte"])

@section('content')
<style>        .search-input {
    width: 250px; /* Ajustez la largeur selon vos besoins */
    margin-right: auto;
    margin-left: auto;
    display: block;
}</style>
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="display-5 text-center text-primary mb-4">📢 Liste des Contributions</h1>

        @if($contributions->isEmpty())
            <p class="text-center text-muted">Aucune contribution enregistrée.</p>
        @else
            <div class="table-responsive">
                <div class="mb-4">
                    <input type="text" id="search" class="form-control search-input" placeholder="Recherche...">
                </div>
                <table  id="users-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#️⃣</th>
                            <th style="color:#08090a;" > Utilisateur</th>
                            <th style="color:#08090a;" > Montant (FCFA)</th>
                            <th style="color:#08090a;" > Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contributions as $key => $contribution)
                            <tr>
                                <td class="fw-bold">{{ $key + 1 }}</td>
                                <td>{{ $contribution->user->name }}</td>
                                <td><span class="badge bg-success">{{ number_format($contribution->amount, 0, ',', ' ') }} FCFA</span></td>
                                <td>{{ $contribution->created_at->format('d/m/Y H:i') }}</td>
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
            font-size: 16px;
            padding: 8px 12px;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #333;
        }
    </style>
@endsection
