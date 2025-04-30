@extends('layout.user', ['title' => 'Contribuer à une campagne'])

@section('content')
<div class="container py-5">
    <div class="card p-4 shadow-sm">
        <h4 class="mb-4">💸 Contribuer à la campagne : {{ $campaign->title }}</h4>

        <form action="{{ route('contribute.store') }}" method="POST">
            @csrf
            <input type="hidden" name="cagnotte_id" value="{{ $campaign->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="anonymat" id="anonymatHidden" value="0">

            <!-- Montant -->
            <div class="mb-3">
                <label for="amount" class="form-label fw-bold">Montant (€)</label>
                <input type="number" class="form-control" name="amount" required min="1"
                    max="{{ $campaign->target_amount - $campaign->collected_amount }}">
            </div>

            <!-- Anonymat -->
            <div class="form-check mb-3">
                <input type="hidden" name="anonymat" value="non">
                <input class="form-check-input" type="checkbox" name="anonymat" id="anonymatCheckbox" value="oui">
                <label class="form-check-label" for="anonymatCheckbox">Contribuer de manière anonyme</label>
            </div>

            <!-- Choix du réseau -->
            <div class="mb-3">
                <label for="network" class="form-label">Réseau</label>
                <select class="form-control" id="network">
                    <option value="">Sélectionnez un réseau</option>
                    <option value="MTN">MTN</option>
                    <option value="MOOV">MOOV</option>
                    <option value="CELTIIS">CELTIIS</option>
                </select>
            </div>

            <!-- Téléphone -->
            <div class="mb-3">
                <label for="phone_number" class="form-label">Téléphone</label>
                <input type="text" class="form-control" name="payment_method" id="phone_number" required>
            </div>

            <button class="btn btn-primary w-100">💳 Contribuer</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

@if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            timer: 3000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            timer: 3000
        });
@endif

    document.addEventListener("DOMContentLoaded", function () {
        let anonymatCheckbox = document.getElementById("anonymatCheckbox");
        let anonymatHidden = document.getElementById("anonymatHidden");
        let networkSelect = document.getElementById("network");
        let phoneInput = document.getElementById("phone_number");

        anonymatCheckbox.addEventListener("change", function () {
            anonymatHidden.value = this.checked ? "1" : "0";
        });

        networkSelect.addEventListener("change", function () {
            let prefix = "";

            switch (this.value) {
                case "MTN": prefix = "+229 90"; break;
                case "MOOV": prefix = "+229 95"; break;
                case "CELTIIS": prefix = "+229 96"; break;
            }

            phoneInput.value = prefix;
        });
    });
</script>
@endsection
