
@auth
@if(auth()->user()->role === 'investor' )

<div class="nk-sidebar is-light nk-sidebar-fixed " data-content="sidebarMenu">
	<div class="nk-sidebar-element nk-sidebar-head">
		<div class="nk-sidebar-brand">
			<a href="index.html" class="logo-link nk-sidebar-logo">
				<img class="logo-light logo-img" src="{{ asset('storage/images/logo.png') }}" srcset="" alt="logo">
				<img class="logo-dark logo-img" src="{{ asset('storage/images/logo.png') }}" srcset="" alt="logo-dark">
				<img class="logo-small logo-img logo-img-small" src="{{ asset('storage/images/logo.png') }}" srcset=""  alt="logo-small">
			</a>
		</div>
		<div class="nk-menu-trigger me-n2">
			<a href="index.html#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
		</div>
	</div>
	<div class="nk-sidebar-element">
		<div class="nk-sidebar-content">
			<div class="nk-sidebar-menu" data-simplebar>
				<ul class="nk-menu">
					<li class="nk-menu-heading"><h6 class="overline-title text-primary-alt">Panel user</h6></li>
					<li class="nk-menu-item">
						<a href="{{route('user.dashboard')}}" class="nk-menu-link">
							<span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
							<span class="nk-menu-text">Tableau de Bord</span>
						</a>
					</li>
					{{-- <li class="nk-menu-item">
						<a href="{{ route('campaigns') }}" class="nk-menu-link">
								<span class="nk-menu-icon">
										<!-- Icône pour les campagnes -->
										<em class="icon ni ni-briefcase"></em> <!-- Icône représentant des campagnes ou un projet -->
								</span>
								<span class="nk-menu-text">Campagnes</span>
						</a>
				</li>
				 --}}
				{{-- <li class="nk-menu-item">
					<a href="{{ route('user.services') }}" class="nk-menu-link">
							<span class="nk-menu-icon">
									<!-- Icône pour les services -->
									<em class="icon ni ni-tools"></em> <!-- Icône représentant des services -->
							</span>
							<span class="nk-menu-text">Service</span>
					</a>
			</li> --}}
			
				
				<li class="nk-menu-item">
						<a href=" " class="nk-menu-link">
								<span class="nk-menu-icon">
										<!-- Icône pour faire une demande -->
										<em class="icon ni ni-send"></em> <!-- Icône représentant l'envoi ou la demande -->
								</span>
								<span class="nk-menu-text">Faire une demande</span>
						</a>
				</li>

				<li class="nk-menu-item">
					<a href=" {{ route('user.transactions') }}" class="nk-menu-link">
							<span class="nk-menu-icon">
									<!-- Icône pour faire une demande -->
									<em class="icon icon-circle bg-success-dim ni ni-wallet"></em> <!-- Icône représentant l'envoi ou la demande -->
							</span>
							<span class="nk-menu-text">Transaction</span>
					</a>
			</li>
				


					<li class="nk-menu-item">
						<a href="{{ route('user.showUser', auth()->user()->id) }}" class="nk-menu-link">
							<span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
							<span class="nk-menu-text">Profil</span>
						</a>
					</li>
					<li class="nk-menu-heading"><h6 class="overline-title text-primary-alt">Retour</h6></li>
					<li class="nk-menu-item">
						<a href="{{route('home')}}" class="nk-menu-link">
							<span class="nk-menu-icon"><em class="icon ni ni-link"></em></span>
							<span class="nk-menu-text">Site Web</span>
						</a>
					</li>

					<li class="nk-menu-item">
						<a href="{{ route('logout') }}" class="nk-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
								<span class="nk-menu-text">Déconnexion</span>
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
						</form>
				</li>
				

				</ul>
			</div>
		</div>
	</div>
</div>


@endif


@if(auth()->user()->role === 'admin')
		<div class="nk-sidebar is-light nk-sidebar-fixed " data-content="sidebarMenu">
			<div class="nk-sidebar-element nk-sidebar-head">
				<div class="nk-sidebar-brand">
					<a href="index.html" class="logo-link nk-sidebar-logo">
						<img class="logo-light logo-img" src="{{ asset('storage/images/logo.png') }}" srcset="" alt="logo">
						<img class="logo-dark logo-img" src="{{ asset('storage/images/logo.png') }}" srcset="" alt="logo-dark">
						<img class="logo-small logo-img logo-img-small" src="{{ asset('storage/images/logo.png') }}" srcset=""  alt="logo-small">
					</a>
				</div>
				<div class="nk-menu-trigger me-n2">
					<a href="index.html#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
				</div>
			</div>
			<div class="nk-sidebar-element">
				<div class="nk-sidebar-content">
					<div class="nk-sidebar-menu" data-simplebar>
						<ul class="nk-menu">
							<li class="nk-menu-heading"><h6 class="overline-title text-primary-alt">Panel user</h6></li>
							<li class="nk-menu-item">
								<a href="{{route('user.dashboard')}}" class="nk-menu-link">
									<span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
									<span class="nk-menu-text">Tableau de Bord</span>
								</a>
							</li>
							<li class="nk-menu-item">
								<a href="{{ route('admin.sessions') }}" class="nk-menu-link">
										<span class="nk-menu-icon">
												<!-- Remplacer l'icône par une icône de session -->
												<em class="icon ni ni-user"></em> <!-- Icône représentant un utilisateur ou session -->
										</span>
										<span class="nk-menu-text">Session</span>
								</a>
						</li>
							<li class="nk-menu-item has-sub">
								<a href="index.html#" class="nk-menu-link nk-menu-toggle">
									<span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span>
									<span class="nk-menu-text">Mes listes</span>
								</a>
								<ul class="nk-menu-sub">
									<li class="nk-menu-item">
										<a href="{{ route('admin.users') }}" class="nk-menu-link"><span class="nk-menu-text">Utilisateurs</span></a>
									</li>
									<li class="nk-menu-item">
										<a href=" {{ route('admin.projects') }} " class="nk-menu-link"><span class="nk-menu-text">Projects</span></a>
									</li>

									<li class="nk-menu-item">
										<a href=" {{ route('admin.campaigns') }} " class="nk-menu-link"><span class="nk-menu-text">Campagne</span></a>
									</li>
									
									<li class="nk-menu-item">
										<a href="{{ route('admin.project_owners') }}" class="nk-menu-link"><span class="nk-menu-text">Agronome</span></a>
									</li>

									<li class="nk-menu-item">
										<a href=" {{ route('admin.services') }} " class="nk-menu-link"><span class="nk-menu-text">Services</span></a>
									</li>

									<li class="nk-menu-item">
										<a href=" {{ route('admin.investments') }} " class="nk-menu-link"><span class="nk-menu-text">Investisement</span></a>
									</li>

									<li class="nk-menu-item">
										<a href=" {{ route('admin.transactions') }} " class="nk-menu-link"><span class="nk-menu-text">Transactions</span></a>
									</li>

									<li class="nk-menu-item">
										<a href=" {{ route('admin.wallets') }} " class="nk-menu-link"><span class="nk-menu-text">Les portefeuils</span></a>
									</li>
									
								</ul>
							</li>

							<li class="nk-menu-item">
								<a href="{{ route('user.showUser', auth()->user()->id) }}" class="nk-menu-link">
										<span class="nk-menu-icon">
												<!-- Icône représentant le profil de l'utilisateur -->
												<em class="icon ni ni-person"></em> <!-- Icône alternative représentant un profil -->
										</span>
										<span class="nk-menu-text">Profil</span>
								</a>
						</li>
						
							<li class="nk-menu-heading"><h6 class="overline-title text-primary-alt">Retour</h6></li>
							<li class="nk-menu-item">
								<a href="{{route('home')}}" class="nk-menu-link">
									<span class="nk-menu-icon"><em class="icon ni ni-link"></em></span>
									<span class="nk-menu-text">Site Web</span>
								</a>
							</li>

							<li class="nk-menu-item">
								<a href="{{ route('logout') }}" class="nk-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
										<span class="nk-menu-text">Déconnexion</span>
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
								</form>
						</li>
						

						</ul>
					</div>
				</div>
			</div>
		</div>

@endif

@endauth
