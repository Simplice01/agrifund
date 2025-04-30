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

        <div class="mt-4">
            <h4>Informations financières</h4>
            <p><strong>Montant cible :</strong> {{ number_format($project->target_amount, 0, ',', ' ') }} FCFA</p>
            <p><strong>Montant collecté :</strong> {{ number_format($project->collected_amount, 0, ',', ' ') }} FCFA</p>

            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" 
                    style="width: {{ ($project->collected_amount / max($project->target_amount, 1)) * 100 }}%;" 
                    aria-valuenow="{{ $project->collected_amount }}" 
                    aria-valuemin="0" 
                    aria-valuemax="{{ $project->target_amount }}">
                    {{ round(($project->collected_amount / max($project->target_amount, 1)) * 100, 2) }}%
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Agronome</h4>
            <p class="text-info"><strong>{{ $project->owner->user->name ?? 'Non défini' }}</strong></p>
            <a href="{{ route('user.show_agronome', $project->owner->user->id) }}" class="btn btn-outline-primary">
    👤 Voir le profil du porteur
</a>
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
