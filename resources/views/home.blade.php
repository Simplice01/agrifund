@extends('layout.app')

@section('content')

<div class="full_bg" style="background: linear-gradient(135deg, #0c4538, #168f65); color: white; padding: 80px 0;">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-md-6">
            <h1 style="font-size: 42px;font-weight:800;" class="fw-bold">🌱 Bienvenue sur <span style="color: #f4f9f7;">AgriFund</span></h1>
            <p class="mt-3 fs-5">
               Une plateforme dédiée au financement participatif pour les agriculteurs, investisseurs et porteurs de projets agricoles.
            </p>
            <a href="#services" class="btn btn-outline-light mt-4">Explorer les opportunités</a>
         </div>
         <div class="col-md-6 text-center">
            <img src="{{ asset('storage/images/banner_img.png') }}" class="img-fluid" alt="Agriculture image" style="max-height: 380px;">
         </div>
      </div>
   </div>
</div>



   <style>
      .feature-box {
          border-radius: 10px;
          padding: 30px 20px;
          transition: all 0.3s ease;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          height: 100%;
      }
  
      .feature-box:hover {
          transform: translateY(-5px);
          box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      }
  
      .feature-icon {
          width: 60px;
          height: 60px;
          margin-bottom: 20px;
      }
  
      .feature-title {
          font-weight: 700;
          font-size: 1.5rem;
          margin-bottom: 10px;
      }
  
      .feature-text {
          color: #555;
          font-size: 0.95rem;
      }
  </style>
  
  <div class="container my-5">
      <div class="text-center mb-5">
          <h2 class="fw-bold" style="color: #2d6a4f;">🌾 Nos Offres Clés</h2>
          <p class="text-muted">Soutenez, investissez et bénéficiez des meilleurs services agricoles</p>
      </div>
  
      <div class="row g-4">
          {{-- Cagnottes --}}
          <div class="col-md-4">
              <div class="feature-box text-center" style="background-color: #e9f5ec; border: 2px solid #40916c;">
                  <img src="{{ asset('storage/images/cagnotte.png') }}" alt="Cagnottes" class="feature-icon">
                  <h3 class="feature-title" style="color: #1b4332;">🎁 Cagnottes</h3>
                  <p class="feature-text">
                      Participez à des collectes solidaires pour soutenir des projets agricoles locaux et communautaires.
                  </p>
              </div>
          </div>
  
          {{-- Projets --}}
          <div class="col-md-4">
              <div class="feature-box text-center" style="background-color: #e0f2ff; border: 2px solid #1d4ed8;">
                  <img src="{{ asset('storage/images/projet.png') }}" alt="Projets" class="feature-icon">
                  <h3 class="feature-title" style="color: #1e3a8a;">🌱 Projets</h3>
                  <p class="feature-text">
                      Investissez dans des projets agricoles innovants, suivez leur avancement et recevez des retours.
                  </p>
              </div>
          </div>
  
          {{-- Services --}}
          <div class="col-md-4">
              <div class="feature-box text-center" style="background-color: #fff5e6; border: 2px solid #d97706;">
                  <img src="{{ asset('storage/images/c') }}" alt="Services" class="feature-icon">
                  <h3 class="feature-title" style="color: #92400e;">🛠️ Services</h3>
                  <p class="feature-text">
                      Bénéficiez de services proposés par des professionnels du secteur agricole pour booster votre activité.
                  </p>
              </div>
          </div>
      </div>
  </div>
  


   <div class="container my-5">
      <div class="text-center mb-5">
      <h2 class="fw-bold" style="color: #2d6a4f;">🛠️ Quelques Services</h2>
       <p class="text-muted">Découvrez des services utiles proposés par nos experts</p>
   </div>

   <div class="row justify-content-center">
       @include('user.partials._service_content', ['services' => $services])
   </div>
</div>





<div class="shop py-5" style="background-color: #f7f7f7;">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-md-6">
            <div class="shop_img text-center" data-aos="fade-right">
               <img class="img-fluid" src="{{ asset('storage/images/banner_img2.png') }}" alt="Image Agriculture" style="max-height: 350px;">
            </div>
         </div>
         <div class="col-md-6">
            <div class="titlepage text-start">
               <h2 class="fw-bold text-success">Financez des projets <br> agricoles durables</h2>
               <p class="mt-3 text-muted">
                  Participez à la transformation de l’agriculture en soutenant des initiatives locales. Chaque contribution compte pour un avenir plus vert et plus nourricier.
               </p>
               <a class="btn btn-success mt-3" href="{{ route('campaigns') }}">Découvrir les cagnottes</a>
            </div>
         </div>
      </div>
   </div>
</div>


 <div class="container my-5">
   <div class="text-center mb-5">
       <h2 class="fw-bold"  style="color: #2d6a4f;">🎯 Quelques Cagnottes</h2>
       <p class="text-muted">Découvrez des campagnes intéressantes à soutenir</p>
   </div>

   <div class="row justify-content-center">
       @include('user.partials._campaign_content', ['campaigns' => $campaigns])
   </div>
</div>


<div class="shop py-5" style="background-color: #eefaf3; overflow-x: hidden;">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-md-6">
            <div class="titlepage text-start">
               <h2 class="fw-bold text-success">Découvrez les services <br> de nos agronomes</h2>
               <p class="mt-3 text-muted">
                  Nos experts vous proposent des services agricoles personnalisés...
               </p>
               <a class="btn btn-outline-success mt-3" href="{{ route('user.services') }}">Voir les services</a>
            </div>
         </div>

         <div class="col-md-6">
            <div class="shop_img text-center">
               <img class="img-fluid w-100" style="max-width:100%; height:auto;" src="{{ asset('storage/images/banner_img.png') }}" alt="Services Agronomes">
            </div>
         </div>
      </div>
   </div>
</div>


@endsection




