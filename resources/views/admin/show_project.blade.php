@extends('layout.user', ['title' => "Mon compte"])

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-primary mb-4">📌 Détails du Projet</h3>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>👤 Agronome :</strong> {{ $project->owner->user->name }}</li>
                    <li class="list-group-item"><strong>📧 Email :</strong> {{ $project->owner->user->email }}</li>
                    <li class="list-group-item"><strong>📛 Titre :</strong> {{ $project->title }}</li>
                    <li class="list-group-item"><strong>📄 Description :</strong> {{ $project->description }}</li>
                </ul>
            </div>

            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item"><strong>🎯 Objectif :</strong> {{ number_format($project->goal_amount, 2) }} €</li>
                    <li class="list-group-item"><strong>💰 Montant Actuel :</strong> {{ number_format($project->current_amount, 2) }} €</li>
                    <form id="statusForm" action="{{ route('admin.updateProjectStatus', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <li class="list-group-item">
                            <strong>📊 Statut :</strong> 
                            <select name="status" id="statusSelect" class="form-select">
                                <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>🕒 En attente</option>
                                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>✅ Validé</option>
                                <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>✅ Complet</option>
                                <option value="failed" {{ $project->status == 'failed' ? 'selected' : '' }}>❌ Rejeté</option>
                            </select>
                        </li>
                        <input type="hidden" name="message" id="messageInput">
                        <button type="button" class="btn btn-success mt-2" onclick="showMessagePopup()">Mettre à jour</button>
                    </form>
                                 
                  </ul>
            </div>
        </div>

        @if($project->cagnotte)
            <div class="mt-4">
                <h4 class="text-success">💳 Cagnotte Associée</h4>
                <ul class="list-group">
                    <li class="list-group-item"><strong>🔗 ID Cagnotte :</strong> {{ $project->cagnotte->id }}</li>
                    <li class="list-group-item"><strong>💸 Montant Collecté :</strong> {{ number_format($project->cagnotte->collected_amount, 2) }} €</li>
                    <a  href="{{ route('admin.show_campaign',$project->cagnotte->id) }}" class=" btn btn-primary">
                      <i class="fas fa-edit"></i> Afficher
                  </a>
                </ul>
            </div>
        @endif

        {{-- <div class="mt-4">
            <h4 class="text-warning">📈 Investissements</h4>
            @if($project->investments->isEmpty())
                <p class="text-muted">Aucun investissement pour ce projet.</p>
            @else
                <ul class="list-group">
                    @foreach($project->investments as $investment)
                        <li class="list-group-item">
                            👤 {{ $investment->investor->name }} - 💰 {{ number_format($investment->amount, 2) }} €
                        </li>
                    @endforeach
                </ul>
            @endif
        </div> --}}

        <div class="text-center mt-4">
            <a href="{{ route('admin.projects') }}" class="btn btn-outline-primary">⬅️ Retour</a>
        </div>
    </div>
</div>
@endsection

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
</script>
