@extends('layout.user', ['title' => "Mon compte"])

@section('content')


<style>
    .content-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f7fafc;
    }

    .profile-card {
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 100%;
        max-width: 800px;
        padding: 20px;
    }

    .profile-header {
        text-align: center;
        background: linear-gradient(to right, #4F46E5, #6B46C1);
        color: #fff;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .profile-header h2 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .profile-header p {
        font-size: 1rem;
        margin-top: 10px;
    }

    .profile-body {
        padding: 20px;
    }

    .profile-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .profile-info img.avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #4F46E5;
        margin-right: 20px;
    }

    .profile-info h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
    }

    .profile-info p {
        font-size: 1rem;
        color: #555;
    }

    .form-container {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: auto;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: bold;
        text-align: center;
        color: #4F46E5;
        margin-bottom: 20px;
    }

    .form-group {
        position: relative;
        margin-bottom: 15px;
    }

    .form-label {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-input:focus {
        border-color: #4F46E5;
        box-shadow: 0px 0px 8px rgba(79, 70, 229, 0.3);
    }

    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: #999;
        cursor: pointer;
    }

    .submit-btn {
        background-color: #4F46E5;
        color: white;
        font-size: 1rem;
        padding: 12px;
        width: 100%;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #6B46C1;
    }

    .error-message {
        color: red;
        font-size: 0.9rem;
        margin-top: 5px;
    }



    .form-input:focus {
        border-color: #4F46E5;
        outline: none;
    }

    .submit-btn {
        background-color: #4F46E5;
        color: #fff;
        padding: 12px 20px;
        width: 100%;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #6B46C1;
    }

    .toggle-btn {
        background-color: #4F46E5;
        color: #fff;
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    .toggle-btn:hover {
        background-color: #6B46C1;
    }

    .password-section {
        display: none;
        margin-top: 20px;
    }

    hr {
        margin: 30px 0;
        border: 1px solid #e2e8f0;
    }
</style>

<div class="content-container">

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



    <div class="profile-card">

        <div class="profile-body">
            <div class="profile-info">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=4F46E5&color=fff&size=120" 
                     class="avatar" 
                     alt="Avatar">
                <div>
                    <h3>{{ $user->name }}</h3>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Rôle:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Membre depuis:</strong> {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <hr>

            <!-- Bouton pour afficher/masquer la section de changement de mot de passe -->
            <button class="toggle-btn" onclick="togglePasswordSection()">Modifier le mot de passe</button>

            <!-- Section de changement de mot de passe -->
            <div class="password-section" id="passwordSection">
                <div class="form-container">
                    <h2 class="form-title">Changer le mot de passe</h2>
                
                    <form action="{{ route('user.updatePassword', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                
                        <!-- Ancien mot de passe -->
                        <div class="form-group">
                            <label for="current_password" class="form-label">Ancien mot de passe</label>
                            <input type="password" name="current_password" id="current_password" class="form-input" required>
                            <span class="input-icon" onclick="togglePassword('current_password')">👁️</span>
                            @error('current_password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <!-- Nouveau mot de passe -->
                        <div class="form-group">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-input" required>
                            <span class="input-icon" onclick="togglePassword('password')">👁️</span>
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <!-- Confirmation du mot de passe -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                            <span class="input-icon" onclick="togglePassword('password_confirmation')">👁️</span>
                            @error('password_confirmation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <!-- Bouton de soumission -->
                        <button type="submit" class="submit-btn">Mettre à jour</button>
                    </form>
                </div>
                
                
                
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordSection() {
        var section = document.getElementById("passwordSection");
        if (section.style.display === "none" || section.style.display === "") {
            section.style.display = "block";
        } else {
            section.style.display = "none";
        }
    }

    function togglePassword(fieldId) {
                        let field = document.getElementById(fieldId);
                        field.type = field.type === "password" ? "text" : "password";
                    }
</script>
@endsection
