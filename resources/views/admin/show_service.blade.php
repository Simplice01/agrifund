@extends('layout.user', ['title' => "Détails du Service"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-success mb-4">🔍 Détails du Service</h3>

        <div class="row">
            <div class="col-md-6">
                <strong>👨‍🌾 Agronome :</strong>
                <p>{{ $service->owner ? $service->owner->user->name : 'Inconnu' }}</p>
            </div>
            <div class="col-md-6">
                <strong>🏷️ Titre :</strong>
                <p>{{ $service->title }}</p>
            </div>
            <div class="col-md-12">
                <strong>📄 Description :</strong>
                <p>{{ $service->description }}</p>
            </div>
            <div class="col-md-6">
                <strong>💶 Prix :</strong>
                <p>{{ number_format($service->price, 2, ',', ' ') }} €</p>
            </div>
            <div class="col-md-6">
                <strong>📊 Statut :</strong>
                <form id="statusForm" action="{{ route('admin.updateServiceStatus', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" id="statusSelect" class="form-select">
                        <option value="pending" {{ $service->status == 'pending' ? 'selected' : '' }}>🕒 En attente</option>
                        <option value="approved" {{ $service->status == 'approved' ? 'selected' : '' }}> ✅ Approuvé</option>
                        <option value="rejected" {{ $service->status == 'rejected' ? 'selected' : '' }}>❌ Rejeté</option>
                    </select>
                    <input type="hidden" name="message" id="messageInput">
                    <button type="button" class="btn btn-success mt-2" onclick="showMessagePopup()">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.services') }}" class="btn btn-outline-success">
                <i class="fas fa-arrow-left"></i> Retour à la liste des services
            </a>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showMessagePopup() {
    let status = document.getElementById('statusSelect').value;
    let statusText = document.getElementById('statusSelect').options[document.getElementById('statusSelect').selectedIndex].text;
    
    Swal.fire({
        title: 'Changer le statut',
        text: `Vous allez changer le statut en "${statusText}". Veuillez entrer un message :`,
        input: 'textarea',
        inputPlaceholder: 'Entrez votre message ici...',
        showCancelButton: true,
        confirmButtonText: 'Envoyer',
        cancelButtonText: 'Annuler',
        inputValidator: (message) => {
            if (!message) {
                return 'Vous devez saisir un message avant de continuer.';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('messageInput').value = result.value;
            document.getElementById('statusForm').submit();
        }
    });
}

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
</script>
@endsection
@section('styles')
    <style>
        .container {
            margin-top: 20px;
        }

        .card {
            background-color: #f8f9fa;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: #fff;
        }

        .badge {
            font-size: 14px;
            padding: 6px 10px;
        }
    </style>
@endsection