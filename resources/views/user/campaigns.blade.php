{{-- @php
    $user = auth()->user();
    $rolesWithUserLayout = ['admin', 'investor', 'project_owners'];

    $layout = (auth()->check() && in_array($user->role, $rolesWithUserLayout))
        ? 'layout.user'
        : 'layout.app';
@endphp --}}

@extends('layout.app')

@section('title', 'Mon compte')


@section('content')
<div class="container ">
    <h3 class="text-center text-primary fw-bold mb-4">🚀 Campagnes de Financement</h3>

    @if($campaigns->isEmpty())
        <div class="alert alert-warning text-center">Aucune campagne disponible pour le moment.</div>
    @else
        <div class="row">
            @foreach($campaigns as $campaign)
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
        </div>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-center mt-4">
            {{ $campaigns->links() }}
        </div> --}}
    @endif
</div>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.03);
    }
    .progress-bar {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        color: white;
    }
</style>
@endsection
