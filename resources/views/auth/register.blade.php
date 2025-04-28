@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color: #168f65;">📝 Inscription</h1>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="mx-auto p-4 border rounded-3 shadow bg-white mt-4" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold text-success">Nom :</label>
            <input type="text" name="name" id="name" class="form-control border-success" placeholder="Entrez votre nom" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-success">Email :</label>
            <input type="email" name="email" id="email" class="form-control border-success" placeholder="Entrez votre email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-success">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control border-success" placeholder="Entrez un mot de passe" required>
            <div id="password-strength" class="mt-2"></div>
            <div class="progress mt-2" style="height: 10px; display: none;" id="password-progress">
                <div class="progress-bar" role="progressbar" id="progress-bar" style="width: 0%;"></div>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold text-success">Confirmer le mot de passe :</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-success" placeholder="Confirmez votre mot de passe" required>
        </div>

        <button type="submit" class="btn w-100 mt-3" style="background-color: #168f65; color: white; font-weight: bold;">
            S'inscrire
        </button>
    </form>
</div>
@endsection

@section('styles')
<style>
    .form-control {
        border-radius: 0.25rem;
    }

    .alert-danger {
        border-radius: 0.25rem;
    }

    .shadow {
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
    }

    #password-strength {
        font-size: 14px;
        font-weight: bold;
    }

    .strength-weak {
        color: #dc3545;
    }

    .strength-medium {
        color: #ffc107;
    }

    .strength-strong {
        color: #168f65;
    }

    .progress-bar {
        transition: width 0.3s ease-in-out;
    }
</style>
@endsection
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
@section('scripts')
<script>
    function checkPasswordStrength(password) {
        const strengthBadge = document.getElementById('password-strength');
        const progressBar = document.getElementById('progress-bar');
        const progressContainer = document.getElementById('password-progress');

        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
        const mediumRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;

        let strength = 0;

        if (strongRegex.test(password)) {
            strength = 100;
            strengthBadge.textContent = 'Mot de passe fort';
            strengthBadge.className = 'strength-strong';
        } else if (mediumRegex.test(password)) {
            strength = 60;
            strengthBadge.textContent = 'Mot de passe moyen';
            strengthBadge.className = 'strength-medium';
        } else {
            strength = 30;
            strengthBadge.textContent = 'Mot de passe faible';
            strengthBadge.className = 'strength-weak';
        }

        progressContainer.style.display = password ? 'block' : 'none';
        progressBar.style.width = `${strength}%`;
    }

    document.getElementById('password').addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
</script>
@endsection
