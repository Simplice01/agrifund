@if(isset($services) && $services->count())
    @foreach($services as $service)
        
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
                {{-- <span class="badge bg-dark fs-6">{{ $badge }}</span> --}}
                
                <div class="mt-3">
                    <a href="{{route('user.show_service', $service->id)}}" class="btn btn-outline-primary">🔍 Voir</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <p class="text-muted">Aucun service disponible pour le moment.</p>
@endif
