{{-- resources/views/user/partials/_campaign_content.blade.php --}}

@if($campaigns->count() > 0)
  @foreach($campaigns->take(5) as $campaign)  
     <div class="col-md-6 col-lg-4 mb-4">
      <div class="card border-0 shadow-lg rounded-lg overflow-hidden bg-white">
          <!-- Image -->
          <img src="{{ asset('storage/' . $campaign->thumbnail) }}" class="card-img-top" alt="Image de la campagne">
  
          <div class="card-body text-center">
              <!-- Titre centré -->
              <h5 class="card-title fw-bold text-dark text-uppercase mb-3">
                  {{ $campaign->title }}
              </h5>

              <!-- Résumé de la description -->
              <p class="text-muted small px-3">
                  {{ Str::words(strip_tags($campaign->description), 10, '...') }}
              </p>
  
              <!-- Montants affichés sous forme "collecté / objectif" avec un design VIP -->
              <div class="bg-light py-2 px-4 rounded-pill d-inline-block fw-bold text-success shadow-sm">
                  💰 {{ number_format($campaign->collected_amount, 0, ',', ' ') }} F /
                  {{ number_format($campaign->target_amount, 0, ',', ' ') }} F 🎯
              </div>
  
              <!-- Barre de progression -->
              @php 
                  $progress = $campaign->target_amount > 0 
                      ? ($campaign->collected_amount / $campaign->target_amount) * 100 
                      : 0;
              @endphp
              <div class="progress mt-3 mb-4" style="height: 8px; border-radius: 20px;">
                  <div class="progress-bar bg-success" role="progressbar" 
                      style="width: {{ $progress }}%; border-radius: 20px;"
                      aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                  </div>
              </div>
  
              <!-- Boutons bien espacés et en vert -->
              <div class="d-flex justify-content-center mt-4 gap-3">
                <a href="{{route('user.show_campaign', $campaign->id)}}" class="btn btn-success btn-sm px-4 fw-bold shadow-sm">
                  🔍 Voir
                </a>
            </div>
            
          </div>
      </div>
  </div>
  
    @endforeach
@else
    <p>Aucune campagne disponible pour le moment.</p>
@endif
