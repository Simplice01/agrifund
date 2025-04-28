@extends('layout.user', ['title' => 'Mes Transactions'])

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center fw-bold">💸 Faire un Transfert</h3>

    {{-- Formulaire de transfert --}}
    @php
    $balance = auth()->user()->wallet->balance ?? 0;
@endphp

<div class="card p-4 shadow-sm mb-5">
    <form action="{{ route('user.transactions.store') }}" method="POST" onsubmit="return validateAmount()">
        @csrf
        <div class="mb-3">
            <label for="numero" class="form-label">Numéro du destinataire</label>
            <input type="text" name="numero" id="numero" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Montant à transférer</label>
            <input type="number" name="amount" id="amount" class="form-control" required min="1" max="{{ $balance }}">
            <small class="text-muted">Votre solde actuel : {{ number_format($balance, 0, ',', ' ') }} FCFA</small>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<script>
    function validateAmount() {
        const amount = parseFloat(document.getElementById('amount').value);
        const max = {{ $balance }};
        if (amount > max) {
            alert('💸 Le montant dépasse votre solde disponible.');
            return false;
        }
        return true;
    }
</script>


    {{-- Liste des transactions --}}
    <h4 class="fw-bold mb-3">📋 Historique de mes transactions</h4>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th> <!-- Remplacement de l’ID par une numérotation -->
                <th>Type</th>
                <th>Montant</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Numérotation automatique -->
                    <td>{{ $transaction->type }}</td>
                    <td>{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge 
                            @if($transaction->status === 'pending') bg-warning
                            @elseif($transaction->status === 'completed') bg-success
                            @elseif($transaction->status === 'failed') bg-danger
                            @else bg-secondary
                            @endif
                        ">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
@endsection
