{{-- @php
    $user = auth()->user();
    $rolesWithUserLayout = ['admin', 'investor', 'project_owners'];

    $layout = (auth()->check() && in_array($user->role, $rolesWithUserLayout))
        ? 'layout.user'
        : 'layout.app';
@endphp
@extends($layout) --}}

@extends('layout.app')


@section('title', 'Mon compte')

@section('content')
<div class="container py-5">
    <h3 class="text-center text-uppercase fw-bold mb-4 text-gold"> 🚀 Services </h3>

    <!-- Barre de recherche stylée -->
    <div class="d-flex justify-content-center mb-4">
        <input type="text" id="searchService" class="form-control form-control-lg w-50 shadow-sm text-center" 
               placeholder="🔍 Rechercher un service..." onkeyup="searchService()">
    </div>

    <div id="serviceList">
        @if($services->isEmpty())
            <p class="text-center text-muted fs-4">Aucun service disponible pour l’instant.</p>
        @else
            <div class="row g-4">
                @foreach($services as $service)
                    @php
                        $daysSinceCreation = \Carbon\Carbon::parse($service->created_at)->diffInDays();
                        $badge = $daysSinceCreation < 10 ? 'Nouveau' : ($daysSinceCreation > 50 ? '⭐⭐⭐⭐⭐' : '⭐⭐⭐');
                    @endphp
    
                    <div class="col-md-6 col-lg-4 service-item" data-title="{{ strtolower($service->title) }}">
                        <div class="card shadow-lg border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <h4 class="fw-bold text-primary service-title">{{ $service->title }}</h4>
                                <p class="fs-5 text-muted">💰 {{ number_format($service->price, 2) }} €</p>
    
                                <!-- Résumé de la description -->
                                <p class="text-muted small px-3">
                                    {{ Str::words(strip_tags($service->description), 20, '...') }}
                                </p>
    
                                <p class="text-secondary small">🗓 Publié le {{ $service->created_at->format('d M Y') }}</p>
                                <span class="badge bg-dark fs-6">{{ $badge }}</span>
                                
                                <div class="mt-3">
                                    <a href="{{route('user.show_service', $service->id)}}" class="btn btn-outline-primary">🔍 Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    
            {{-- <div class="mt-4">
                {{ $services->links('pagination::bootstrap-4') }}
            </div> --}}
        @endif
    </div>
    
</div>
@endsection

@section('styles')
<style>
    body {
        background: #f5f5f5;
    }
    .text-gold {
        color: #FFD700;
    }
    .card {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .btn-primary {
        background-color: #FFD700;
        border-color: #FFD700;
        color: #000;
    }
    .btn-primary:hover {
        background-color: #FFC107;
    }
    /* Ajustement de la barre de recherche */
    #searchService {
        width: 30%;
        max-width: 300px;
        border-radius: 50px;
        border: 2px solid #FFD700;
        padding: 4px 10px;
    }
    #searchService:focus {
        border-color: #FFC107;
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
    }
</style>
@endsection

@section('scripts')
<script>
   function searchService() {
    let input = document.getElementById("searchService").value.toLowerCase().trim();
    let services = document.querySelectorAll(".service-item");
    let noResult = true;

    services.forEach(service => {
        let title = service.querySelector(".service-title").innerText.toLowerCase();
        if (title.includes(input)) {
            service.style.display = "block";
            noResult = false;
        } else {
            service.style.display = "none";
        }
    });

    // Vérifier si on doit afficher ou non le message "Aucun service trouvé"
    let serviceList = document.getElementById("serviceList");
    let noResultMsg = document.getElementById("noResultMsg");

    if (noResult) {
        if (!noResultMsg) {
            let msg = document.createElement("p");
            msg.id = "noResultMsg";
            msg.className = "text-center text-danger fw-bold mt-3";
            msg.innerText = "😕 Aucun service trouvé.";
            serviceList.appendChild(msg);
        }
    } else {
        if (noResultMsg) {
            noResultMsg.remove();
        }
    }
}

</script>
@endsection
