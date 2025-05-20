@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <h2 class="text-center text-gold mb-4">Create Account</h2>
                
                <form method="POST" action="{{ route('do-register') }}" class="auth-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-gold">Name</label>
                        <input type="text" name="name" class="form-control custom-input" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gold">Email</label>
                        <input type="email" name="email" class="form-control custom-input" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gold">Password</label>
                        <input type="password" name="password" class="form-control custom-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control custom-input" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gold">Register</button>
                        <a href="{{ route('login_with_google') }}" class="btn btn-outline-gold">
                            <i class="fab fa-google me-2"></i>Register with Google
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="{{ route('login') }}" class="text-gold">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .text-gold {
        color: #D4AF37;
    }

    .custom-input {
        background-color: rgba(44, 30, 30, 0.7);
        border: 1px solid #D4AF37;
        color: #f5f5f5;
    }

    .custom-input:focus {
        background-color: rgba(44, 30, 30, 0.9);
        border-color: #D4AF37;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        color: #f5f5f5;
    }

    .btn-gold {
        background-color: #D4AF37;
        border-color: #D4AF37;
        color: #2c1e1e;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background-color: #B38F28;
        border-color: #B38F28;
        transform: translateY(-2px);
    }

    .btn-outline-gold {
        border: 1px solid #D4AF37;
        color: #D4AF37;
        background-color: transparent;
    }

    .btn-outline-gold:hover {
        background-color: #D4AF37;
        color: #2c1e1e;
        transform: translateY(-2px);
    }
</style>
@endsection
