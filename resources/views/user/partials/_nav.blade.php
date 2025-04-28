@auth

  
  @if(auth()->user()->role === 'admin')
 
    <div class="nk-header is-light nk-header-fixed is-light">
        <div class="container-xl wide-xl">
          <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
              <a href="index.html#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
              <a href="index.html" class="logo-link">
                <img class="logo-light logo-img" src=" " srcset=" " alt="logo">
                <img class="logo-dark logo-img" src="" srcset=" " alt="logo-dark">
              </a>
            </div>
            <div class="nk-header-menu is-light">
              <div class="nk-header-menu-inner">
                <ul class="nk-menu nk-menu-main">
                  <li class="nk-menu-item">
                    <a href="{{route('home')}}" class="nk-menu-link"><span class="nk-menu-text"><em class="icon ni ni-chevron-left"></em> Retourner au site</span></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="nk-header-tools">
              <ul class="nk-quick-nav">
                {{-- <li class="dropdown notification-dropdown">
                  <a href="index.html#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                    <div class="icon-status icon-status-info">
                      <em class="icon ni ni-bell"></em>
                    </div>
                  </a> --}}
                  <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                    <div class="dropdown-head">
                      <span class="sub-title nk-dropdown-title">Notifications</span>
                      <a href="index.html#">Mark All as Read</a>
                    </div>
                    <div class="dropdown-body">
                      <div class="nk-notification">
                        <div class="nk-notification-item dropdown-inner">
                          <div class="nk-notification-icon">
                            <em class="icon icon-circle bg-primary-dim ni ni-share"></em>
                          </div>
                          <div class="nk-notification-content">
                            <div class="nk-notification-text">
                              Iliash shared
                              <span>Dashlite-v2</span>
                              with you.
                            </div>
                            <div class="nk-notification-time">
                              Just now
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="dropdown-foot center">
                      <a href="index.html#">View All</a>
                    </div>
                  </div>
                </li>
                <li class="dropdown user-dropdown">
                  <a href="index.html#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-toggle">
                      <div class="user-avatar sm">
                        <em class="icon ni ni-user-alt"></em>
                      </div>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                    <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                      <div class="user-card">
                        <div class="user-avatar">
                          <span>A</span>
                        </div>
                        <div class="user-info">
                          <span class="lead-text">{{ auth()->user()?->name ?? 'User' }}</span>
                          <span class="sub-text">-</span>
                        </div>
                      </div>
                    </div>
                    <div class="dropdown-inner">
                      <ul class="link-list">
                        <li>
                          <a href="{{ route('user.showUser', auth()->user()->id) }}" class="text-blue-500 hover:underline">
                          <em class="icon ni ni-user-alt"></em>
                            <span>Voir Profile</span>
                          </a>
                        </li>
                        {{-- <li>
                          <a href="history.html">
                            <em class="icon ni ni-clock"></em>
                            <span>Voir Historique</span>
                          </a>
                        </li> --}}
                      </ul>
                    </div>
                    <div class="dropdown-inner">
                      <ul class="link-list">
                        <li>

                          <a href="{{ route('logout') }}" class="nk-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <em class="icon ni ni-signout"></em>
                            <span>Se deconnecter</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>


                        </li>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
  @endif

  @if(auth()->user()->role === 'investor')

   
  <div class="nk-header is-light nk-header-fixed is-light">
    <div class="container-xl wide-xl">
      <div class="nk-header-wrap">
        <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
          <a href="index.html#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-header-brand d-xl-none">
          <a href="index.html" class="logo-link">
            <img class="logo-light logo-img" src=" " srcset=" " alt="logo">
            <img class="logo-dark logo-img" src="" srcset=" " alt="logo-dark">
          </a>
        </div>
        <div class="nk-header-menu is-light">
          <div class="nk-header-menu-inner">
            <ul class="nk-menu nk-menu-main">
              <li class="nk-menu-item">
                <a href="{{route('home')}}" class="nk-menu-link"><span class="nk-menu-text"><em class="icon ni ni-chevron-left"></em> Retourner au site</span></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="nk-header-tools">
          <ul class="nk-quick-nav">
            <li class="dropdown notification-dropdown">
              <a href="index.html#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                <div class="icon-status icon-status-info">
                  <em class="icon ni ni-bell"></em>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                <div class="dropdown-head">
                  <span class="sub-title nk-dropdown-title">Notifications</span>
                  <a href="{{ route('notifications.index') }}">Voir tous</a>
                </div>
                <div class="dropdown-body">
                  <div class="nk-notification">
                      @if(isset($notifications) && $notifications->count() > 0)
                          @foreach ($notifications as $notification)
                              <div class="nk-notification-item dropdown-inner">
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
                                  <div class="nk-notification-content">
                                      <div class="nk-notification-text">
                                          {{ $notification->message }}
                                      </div>
                                      <div class="nk-notification-time">
                                          {{ $notification->created_at->diffForHumans() }}
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      @else
                          <div class="nk-notification-item dropdown-inner">
                              <div class="nk-notification-content">
                                  <div class="nk-notification-text">
                                      Aucune notification pour le moment.
                                  </div>
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
                            
                <div class="dropdown-foot center">
                  <a href="{{ route('notifications.index') }}">Voir tous</a>
                </div>
              </div>
            </li>
            <li class="dropdown user-dropdown">
              <a href="index.html#" class="dropdown-toggle" data-bs-toggle="dropdown">
                <div class="user-toggle">
                  <div class="user-avatar sm">
                    <em class="icon ni ni-user-alt"></em>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                  <div class="user-card">
                    <div class="user-avatar">
                      <span>A</span>
                    </div>
                    <div class="user-info">
                      <span class="lead-text">{{ auth()->user()?->name ?? 'User' }}</span>
                      <span class="sub-text">-</span>
                    </div>
                  </div>
                </div>
                <div class="dropdown-inner">
                  <ul class="link-list">
                    <li>
                      <a href="{{ route('user.showUser', auth()->user()->id) }}" class="text-blue-500 hover:underline">
                      <em class="icon ni ni-user-alt"></em>
                        <span>Voir Profile</span>
                      </a>
                    </li>

                  </ul>
                </div>
                <div class="dropdown-inner">
                  <ul class="link-list">
                    <li>

                      <a href="{{ route('logout') }}" class="nk-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <em class="icon ni ni-signout"></em>
                        <span>Se deconnecter</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>


                    </li>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  @endif

  @endauth
