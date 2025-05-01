{{-- @extends('layout.user',['title'=>"Mon compte"]) --}}
@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg p-4">
        <h1 class="text-center text-primary">{{ $project->title }}</h1>
        <p class="text-muted text-center">Créé le : {{ $project->created_at->format('d M Y') }}</p>

        <div class="mt-4">
            <h4>Description</h4>
            <p class="lead">{{ $project->description }}</p>
        </div>

        <div class=" mt-4">
            <div style="padding: 10px;" class="row text-center mt-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="p-3 border rounded bg-light shadow-sm">
                        <h6 class="text-muted"><i class="bi bi-bullseye text-primary me-1"></i> Montant cible</h6>
                        <h4 class="text-primary fw-bold">{{ number_format($project->goal_amount, 0, ',', ' ') }} FCFA</h4>
                    </div>
                </div>
                <div style="padding: 10px;" class="col-md-6">
                    <div class="p-3 border rounded bg-light shadow-sm">
                        <h6 class="text-muted"><i class="bi bi-cash-stack text-success me-1"></i> Montant collecté</h6>
                        <h4 class="text-success fw-bold">{{ number_format($project->current_amount, 0, ',', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
            


            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" 
                    style="width: {{ ($project->current_amount / max($project->goal_amount, 1)) * 100 }}%;" 
                    aria-valuenow="{{ $project->current_amount }}" 
                    aria-valuemin="0" 
                    aria-valuemax="{{ $project->target_amount }}">
                    {{ round(($project->current_amount / max($project->goal_amount, 1)) * 100, 2) }}%
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Publié par: <a style="font-weight:bold;" href="{{ route('user.show_agronome', $project->owner->user->id) }}" >
                {{ $project->owner->user->name ?? 'Non défini' }}
          </a></h4>
            
        </div>


        <div class="mt-5">
          @if ($campaigns->isNotEmpty())
          <h3 class="text-primary">Campagnes associées</h3>
          <div class="row">
              @foreach ($campaigns as $campaign)
                  <div class="col-md-4">
                      <div class="card mb-3 shadow-sm">
                          <img src="{{ asset('storage/' . $campaign->thumbnail) }}" class="card-img-top" alt="{{ $campaign->title }}">
                          <div class="card-body">
                              <h5 class="card-title">{{ $campaign->title }}</h5>
                              <p class="text-muted">Montant : {{ number_format($campaign->target_amount, 0, ',', ' ') }} FCFA</p>
                              <a href="{{ route('user.show_campaign', $campaign->id) }}" class="btn btn-outline-primary">Voir la campagne</a>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @else
          <p class="text-center text-danger">Aucune campagne associée.</p>
      @endif
      
            </div>

            
        </div>
    </div>
</div>
@endsection
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
