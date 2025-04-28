<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>{{ config('app.name', 'AGRIFUND') }}</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('css/css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" href="{{ asset('css/css/style.css') }}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('css/css/responsive.css') }}">

      <!-- SweetAlert2 -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
      <!-- favicon -->
      <link rel="icon" href="{{ asset('storage/images/fevicon.png') }}" type="image/gif" />
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader -->
      <div class="loader_bg">
         <div class="loader"><img src="{{ asset('storage/images/loading.gif') }}" alt="#"/></div>
      </div>
      <!-- end loader -->

      <!-- header -->
      <header style="background:none;margin-bottom:5px;">
         <div class="header">
            <div class="container-fluid">
               <div class="row d_flex">
                  <div class="col-md-2 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="{{ route('home') }}">
                                 <img src="{{ asset('storage/images/logo.png') }}" alt="#" class="img-fluid" style="max-height: 100px;">
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-12">
                     <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="{{ route('home') }}">Home</a>
                              </li>
                              
                              <!-- Lien vers les campagnes actives -->
                              <li class="nav-item">
                                 <a class="nav-link" href="{{route('campaigns')}}">Campagnes</a>
                              </li>

                              <!-- Lien vers les services -->
                              <li class="nav-item">
                                 <a class="nav-link" href="{{route('user.services')}}">Services</a>
                              </li>

                              @auth
                                 <li class="nav-item">
                                    <a class="nav-link" href="{{route('user.dashboard')}}">Dashboard</a>
                                 </li>
                                 <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="nav-link" type="submit">Déconnexion</button>
                                 </form>
                              @else
                                 <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                                 </li>

                                 <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Inscription</a>
                                 </li>
                              @endauth
                           </ul>
                        </div>
                     </nav>
                  </div>
                  <div class="col-md-2">
                     <ul class="email text_align_right">
                        {{-- <li class="d_none"><a href="Javascript:void(0)"><i class="fa fa-user" aria-hidden="true"></i></a></li> --}}
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>

      <main>
         <div>
            @yield('content')
         </div>
      </main>

      <!-- footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-4">
                     <div class="infoma">
                        <h3>Contacts</h3>
                        <ul class="conta">
                           <li><i class="fa fa-map-marker" aria-hidden="true" style="color: #3e6606;"></i> Adresse</li>
                           <li><i class="fa fa-phone" aria-hidden="true" style="color: #3e6606;"></i> Tel : +229 1234567890</li>
                           <li><i class="fa fa-envelope" aria-hidden="true" style="color: #3e6606;"></i><a href="Javascript:void(0)"> agrifund@gmail.com</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="row border_left">
                        <div class="col-md-12">
                           <div class="infoma"> 
                              <h3>Newsletter</h3>
                              <form class="form_subscri">
                                 <div class="row">
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Entrer votre prénom" type="text" name="prenom">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Entrer votre email" type="text" name="email">
                                    </div>
                                    <div class="col-md-4">
                                       <button class="subsci_btn">S'abonner</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="infoma">
                              <h3>Liens utiles</h3>
                              <ul class="fullink">
                                 <li><a href="#">Campagnes</a></li>
                                 <li><a href="#">Services</a></li>
                                 <li><a href="#">A propos</a></li>
                                 <li><a href="#">Contact</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="infoma text_align_left">
                              <ul class="social_icon">
                                 <li><a href="Javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>&copy; 2025 AgriFund | Tous droits réservés</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>

      <!-- end footer -->
      <!-- Javascript files-->
      <script src="{{ asset('js/js/jquery.min.js') }}"></script>
      <script src="{{ asset('js/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('js/js/custom.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
         AOS.init();
          @if(session('success'))
              Swal.fire({
                  icon: 'success',
                  title: 'Succès!',
                  text: '{{ session('success') }}',
                  showConfirmButton: true,
                  timer: 3000
              });
          @elseif(session('error'))
              Swal.fire({
                  icon: 'error',
                  title: 'Erreur!',
                  text: '{{ session('error') }}',
                  showConfirmButton: true,
                  timer: 3000
              });
          @endif
      </script>
   </body>
</html>
