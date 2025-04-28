@extends('layout.app')

@section('content')


<div class="container mt-5">
    <h1 class="text-center" style="color: #168f65;">🔐 Connexion</h1>

    {{-- Formulaire de connexion --}}
    <form action="{{ route('login') }}" method="POST" class="w-100 w-md-50 mx-auto p-4 border rounded-3 shadow bg-white" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-success">Email</label>
            <input type="email" name="email" id="email" class="form-control border-success" placeholder="Entrez votre email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-success">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control border-success" placeholder="Entrez votre mot de passe" required>
        </div>

        <button type="submit" class="btn w-100 mt-3" style="background-color: #168f65; color: white;">Se connecter</button>

        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary">Mot de passe oublié ?</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

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

@endsection


