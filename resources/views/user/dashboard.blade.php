@php
    $user = auth()->user();
    $rolesWithUserLayout = ['admin', 'investor', 'project_owners'];

    $layout = (auth()->check() && in_array($user->role, $rolesWithUserLayout))
        ? 'layout.user'
        : 'layout.app';
@endphp

@extends($layout)

@section('title', 'Mon compte')


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

@auth

@if(auth()->user()->role === 'admin')
        <div class="nk-content nk-content-fluid">
            <div class="container-xl wide-xl">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Bienvenue</h3>
                                <div class="nk-block-des text-soft">
                                    <p>
                                        Bon retour sur votre tableau de bord <strong> {{ auth()->user()?->name ?? 'User' }}</strong> !
                                    </p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                {{-- <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <em class="d-none d-sm-inline icon ni ni-calender-date"></em>
                                                        <span><span class="d-none d-md-inline">Last</span> 30 Days</span>
                                                        <em class="dd-indc icon ni ni-chevron-right"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#"><span>Last 30 Days</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><span>Last 6 Months</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><span>Last 1 Years</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> --}}
                                            </li>
                                            {{-- <li class="nk-block-tools-opt">
                                                <a href="#" class="btn btn-primary">
                                                    <em class="icon ni ni-reports"></em>
                                                    <span>Reports</span>
                                                </a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-success">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="fs-6 text-white text-opacity-75 mb-0">
                                                Montant campagne
                                            </div>
                                            <a href="history.html" class="link link-white">{{ number_format($totalCampaignsAmount, 2) }}f cfa</a>
                                        </div>
                                        <h5 class="fs-1 text-white">
                                            {{ number_format($totalCampaignsAmountget, 2) }}  
                                            <small class="fs-3">
                                                F CFA 
                                            </small>
                                        </h5>
                                        <div class="fs-7 text-white text-opacity-75 mt-1">
                                            <span class="text-white"><a href="{{ route('admin.campaigns') }}" class="text-white"><em class="icon ni ni-reply-all"></em>Liste</a></span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-warning is-dark">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="fs-6 text-white text-opacity-75 mb-0">
                                                Nombre d'utilisateur
                                            </div>
                                            <a href="document-drafts.html" class="link link-white">-</a>
                                        </div>
                                        <h5 class="fs-1 text-white">
                                            {{ number_format($totalUsers) }}   
                                            <small class="fs-3">
                                               
                                            </small>
                                        </h5>
                                        <div class="fs-7 text-white text-opacity-75 mt-1">
                                            <span class="text-white"><a href="{{ route('admin.users') }}" class="text-white"><em class="icon ni ni-reply-all"></em> liste</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-info is-dark">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="fs-6 text-white text-opacity-75 mb-0">
                                                Nombre de projet
                                            </div>
                                            <a href="document-saved.html" class="link link-white">-</a>
                                        </div>
                                        <h5 class="fs-1 text-white">
                                              {{ number_format($totalProjects) }} 
                                            <small class="fs-3">
                                               
                                            </small>
                                        </h5>
                                        <div class="fs-7 text-white text-opacity-75 mt-1">
                                            <span class="text-white"><a href="{{ route('admin.projects') }}" class="text-white"><em class="icon ni ni-reply-all"></em> liste</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-danger is-dark">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="fs-6 text-white text-opacity-75 mb-0">
                                                Nombre de campagne
                                            </div>
                                            <a href="templates.html" class="link link-white">-</a>
                                        </div>
                                        <h5 class="fs-1 text-white">
                                             {{ number_format($totalCampaigns) }} 
                                            <small class="fs-3">
                                                
                                            </small>
                                        </h5>
                                        <div class="fs-7 text-white text-opacity-75 mt-1">
                                            <span class="text-white"><a href="{{ route('admin.campaigns') }}" class="text-white"><em class="icon ni ni-reply-all"></em> liste</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">-</h4>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-sm-5 col-xxl-2">
                                <div class="mt-5">
                                    <h4 class="text-center">📈 Évolution des Transactions</h4>
                                    <canvas id="transactionChart"></canvas>
                                </div>
                                
                            </div>
                            <div class="col-sm-7 col-xxl-4">
                                <div class="card card-full">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                    Cagnotte en cours
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list mt-n2">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col">
                                                <span>No.</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm">
                                                <span>Titre</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span>Date</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>Budget</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span class="d-none d-sm-inline">Collecté</span>
                                            </div>
                                        </div>
                            
                                        <!-- Affichage des campagnes en cours -->
                                        @foreach ($activeCampaigns as $campaign)
                    
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead"><a href="#">{{ $campaign->id }}</a></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <div class="user-card">
                                                        <div class=" sm ">
                                                            <span>{{ $campaign->title }}</span>
                                                        </div>
                                                        <div class="user-name">
                                                            <span class="tb-lead"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">{{ $campaign->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-sub tb-amount">{{ number_format($campaign->target_amount, 2) }} <span>F CFA</span></span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dot badge-dot-xs bg-success">{{ number_format($campaign->collected_amount, 2) }}<span>F CFA</span></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endif
@if(auth()->user()->role === 'investor' )

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Bienvenue</h3>
                        <div class="nk-block-des text-soft">
                            <p>
                                Bon retour sur votre tableau de bord <strong> {{ auth()->user()?->name ?? 'User' }}</strong> !
                            </p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                   
                                    <li class="nk-block-tools-opt">
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="card card-full bg-success">
                            <div class="card-inner">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="fs-6 text-white text-opacity-75 mb-0">
                                        Mes contributions
                                    </div>  
                                    <a href="history.html" class="link link-white"> {{ $totalContributions }}</a>
                                </div>
                                <h5 class="fs-1 text-white">
                                    {{ number_format($totalContributionAmount, 2) }}   F CFA 
                                    <small class="fs-3">
                                         
                                    </small>
                                </h5>
                                <div class="fs-7 text-white text-opacity-75 mt-1">
                                    <span class="text-white"><a href="#" class="text-white"><em class="icon ni ni-reply-all"></em>Liste</a></span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-xxl-3">
                        <div class="card card-full bg-warning is-dark">
                            <div class="card-inner">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="fs-6 text-white text-opacity-75 mb-0">
                                        Mon portefeuil
                                    </div>
                                    <a href="document-drafts.html" class="link link-white">-</a>
                                </div>
                                <h5 class="fs-1 text-white">
                                    {{ number_format($walletBalance, 2) }} F CFA  
                                    <small class="fs-3">
                                       
                                    </small>
                                </h5>
                                <div class="fs-7 text-white text-opacity-75 mt-1">
                                    <span class="text-white"><a href="#" class="text-white"><em class="icon ni ni-reply-all"></em> liste</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="nk-block-head">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">-</h4>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="row g-gs">
                    
                    <div class="col-sm-7 col-xxl-4">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            Mes contributions
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list mt-n2">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col">
                                        <span>No.</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <span>Date</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>Montant</span>
                                    </div>
                                 
                                    <div class="nk-tb-col">
                                        <span class="d-none d-sm-inline">Voir</span>
                                    </div>
                                </div>
                    
                             
                                @foreach ($userContributions as $contribution)
            
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead"><a href="#">{{ $contribution->id }}</a></span>
                                        </div>
                                        
                                        <div class="nk-tb-col tb-col-md">
                                            <span class="tb-sub">{{ $contribution->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="tb-sub tb-amount">{{ number_format($contribution->amount, 2) }} <span>F CFA</span></span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="tb-sub tb-amount">{{ number_format($contribution->amount, 2) }} <span>F CFA</span></span>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div>
                {{-- <div style="padding:25px;">
                    <h3 style="text-align:center;">Quelques cagnottes</h3>
                    @include('user.partials._campaign_content', ['campaigns' => $campaigns])
                </div> --}}
            </div>
        </div>
    </div>
</div>





@endif
@endauth

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($transactions->pluck('date')) !!},
                datasets: [{
                    label: 'Transactions ($)',
                    data: {!! json_encode($transactions->pluck('total')) !!},
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });
    });
</script>
@endsection




