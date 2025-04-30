@extends('layout.user', ['title' => 'Détails de la Campagne'])

@section('content')

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            confirmButtonText: 'Ok',
            background: '#f4f4f9'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}',
            confirmButtonText: 'Ok',
            background: '#f4f4f9'
        });
    </script>
@endif

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-primary mb-4">💰 Détails de la Campagne</h3>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong> Titre :</strong> {{ $campaign->title }}</li>
                    <li class="list-group-item"><strong> Description :</strong> {{ $campaign->description }}</li>
                    <li class="list-group-item"><strong> Montant Cible :</strong> {{ number_format($campaign->target_amount, 2) }} €</li>
                    <li class="list-group-item"><strong> Montant Collecté :</strong> {{ number_format($campaign->collected_amount, 2) }} €</li>
                    <li class="list-group-item">
                        <strong>🕒 Date de fin :</strong> 
                        <span class="{{ \Carbon\Carbon::parse($campaign->date_fin) > now() ? 'text-danger' : '' }}">
                            {{ \Carbon\Carbon::parse($campaign->date_fin)->format('d/m/Y H:i') }}
                        </span>
                        
                    </li>                    <li class="list-group-item"><strong>📝 Statut :</strong> 
                        <span class="badge {{ $campaign->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $campaign->status }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>👤 Agronome :</strong> 
                        <a href="{{ route('admin.show_user', $campaign->project->owner->user->id) }}" class="text-primary">
                            {{ $campaign->project->owner->user->name }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="Thumbnail" class="img-fluid rounded">
                <div class="mt-4">
                    <h4 class="text-warning">📈 Investissements</h4>
                    @if($campaign->investments->isEmpty())
                        <p class="text-muted">Aucun investissement pour ce projet.</p>
                    @else
                        <ul class="list-group">
                            @foreach($campaign->investments as $investment)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        👤 <strong>{{ $investment->investor->name }}</strong><br>
                                        💰 {{ number_format($investment->amount, 2) }} €<br>
                                        🕒 {{ $investment->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <span class="badge 
                                        @if($investment->status === 'pending') bg-warning 
                                        @elseif($investment->status === 'refunded') bg-secondary 
                                        @elseif($investment->status === 'validated') bg-success 
                                        @else bg-dark 
                                        @endif">
                                        {{ ucfirst($investment->status) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
                @if($campaign->status !== 'closed' && $campaign->status !== 'failed')
    <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
        <!-- Bouton Annuler -->
        <form id="cancel-form" action="{{ route('campaigns.cancel', $campaign->id) }}" method="POST">
            @csrf
            <input type="hidden" name="message" id="cancel-message">
        </form>
        <button class="btn btn-danger" onclick="showCancelPopup()">❌ Annuler la Campagne</button>

        <!-- Bouton Valider si la campagne est en attente -->
        @if($campaign->status === 'pending')
            <form action="{{ route('campaigns.validate', $campaign->id) }}" method="POST">
                @csrf
                <button class="btn btn-success">✅ Valider la Campagne</button>
            </form>
        @endif
    </div>
@endif


            </div>

        </div>

        <div class="mt-4">
            <h4 class="text-success">📌 Projet Associé</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>👤 Projet :</strong> {{ $campaign->project->title }}</li>
                <li class="list-group-item"><strong>📛 Description :</strong> {{ $campaign->project->description }}</li>
                <a href="{{ route('admin.show_project', ['id' => $campaign->project->id]) }}" class="btn btn-sm btn-info">
                  Afficher
              </a>
              
            </ul>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.projects') }}" class="btn btn-outline-primary">⬅️ Retour</a>
        </div>
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
function showCancelPopup() {
    Swal.fire({
        title: 'Annuler la Campagne',
        input: 'textarea',
        inputPlaceholder: 'Expliquez la raison de l\'annulation...',
        inputAttributes: {
            'aria-label': 'Expliquez la raison de l\'annulation'
        },
        showCancelButton: true,
        confirmButtonText: 'Envoyer',
        cancelButtonText: 'Annuler',
        preConfirm: (message) => {
            if (!message) {
                return Swal.showValidationMessage('Vous devez entrer un message.');
            }
            return message;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            sendCancelRequest(result.value);
        }
    });
}

function sendCancelRequest(message) {
    // Met à jour le champ caché du formulaire avec le message
    document.getElementById("cancel-message").value = message;

    // Soumet le formulaire
    document.getElementById("cancel-form").submit();
}
</script>
@endsection

