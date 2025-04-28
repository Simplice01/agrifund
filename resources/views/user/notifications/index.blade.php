@extends('layout.user', ['title' => "Mes Notifications"])

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🔔 Mes Notifications</h3>
    <div class="card shadow p-3">
        @foreach ($notifications as $notification)
            <div class="d-flex align-items-center border-bottom py-2">
                <div class="nk-notification-icon">
                    <!-- Choisir l'icône selon le type de notification -->
                    @if($notification->type == 'alert')
                        <em class="icon icon-circle bg-danger-dim ni ni-alert"></em> <!-- Alerte -->
                    @elseif($notification->type == 'info')
                        <em class="icon icon-circle bg-info-dim ni ni-info"></em> <!-- Information -->
                    @elseif($notification->type == 'paiement')
                        <em class="icon icon-circle bg-success-dim ni ni-wallet"></em> <!-- Paiement -->
                    @elseif($notification->type == 'validation')
                        <em class="icon icon-circle bg-primary-dim ni ni-check-circle"></em> <!-- Validation -->
                    @else
                        <em class="icon icon-circle bg-secondary-dim ni ni-notification"></em> <!-- Autre -->
                    @endif
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1">{{ $notification->message }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <div>
                    @if(!$notification->lu)
                        <button class="btn btn-sm btn-warning mark-read" data-id="{{ $notification->id }}">👁️</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.mark-read').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.dataset.id;
                fetch(`/notifications/${id}/mark-as-read`, {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Succès', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Erreur', data.message, 'error');
                    }
                });
            });
        });

        document.querySelectorAll('.delete-notification').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.dataset.id;
                Swal.fire({
                    title: "Êtes-vous sûr?",
                    text: "Cette action est irréversible!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Oui, supprimer!",
                    cancelButtonText: "Annuler"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/notifications/${id}`, {
                            method: "DELETE",
                            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Supprimé!', data.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Erreur', data.message, 'error');
                            }
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
