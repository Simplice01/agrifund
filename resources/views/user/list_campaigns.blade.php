@extends('layout.user',['title'=>"Mon compte"])
 
@section('content')
<div class="container py-5">
    <div style="padding:25px;">
      <h3 style="text-align:center;">Quelques cagnottes</h3>
      @include('user.partials._campaign_content', ['campaigns' => $campaigns])
   </div>
</div>
@endsection