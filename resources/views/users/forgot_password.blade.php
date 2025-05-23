@extends('layouts.master')

@section('title', 'Forgot Password - NebulaAuth')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #2c1e1e !important;
    color: #fffbe6;
    overflow-x: hidden;
  }

  .login-fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #2c1e1e !important;
  }

  .login-form-wrapper {
    width: 100%;
    max-width: 400px;
    background: #2c1e1e !important;
    border-radius: 1.5rem;
    padding: 2.5rem 2rem 2rem 2rem;
    border: 2px solid #D4AF37;
    box-shadow: 0 0 30px rgba(212, 175, 55, 0.2);
  }

  .login-icon-wrapper {
    background: #2c1e1e;
    border: 2px solid #D4AF37;
    color: #D4AF37;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 0 32px 0 rgba(212, 175, 55, 0.2);
  }

  .login-icon-wrapper .bi {
    font-size: 2.5rem;
  }

  .form-control-dark {
    background: #2c1e1e !important;
    color: #fffbe6 !important;
    border: 1.5px solid #D4AF37 !important;
    border-radius: 0.5rem;
    padding: 0.85rem 1.1rem;
  }

  .form-control-dark::placeholder {
    color: #fffbe6 !important;
    opacity: 1;
  }

  .form-control-dark:focus {
    border-color: #ffd700 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.2);
    background: rgba(50, 45, 35, 0.9) !important;
  }

  .input-group-text-dark {
    background: #2c1e1e !important;
    border: 1.5px solid #D4AF37 !important;
    color: #D4AF37 !important;
    border-radius: 0.5rem 0 0 0.5rem;
  }

  .btn-custom-primary {
    background: #D4AF37 !important;
    border: 2px solid #D4AF37 !important;
    color: #2c1e1e !important;
    font-weight: 600;
    transition: all 0.3s ease;
    border-radius: 0.5rem;
  }

  .btn-custom-primary:hover, .btn-custom-primary:focus {
    background: #2c1e1e !important;
    color: #D4AF37 !important;
    border: 2px solid #D4AF37 !important;
  }

  .link-custom {
    color: #ffd700;
  }

  .link-custom:hover {
    color: #daa520;
  }

  .text-muted-custom {
    color: #d4c091 !important;
  }

  .alert-danger {
    background: #2c1e1e;
    border-color: #D4AF37;
    color: #fffbe6;
  }
</style>
@endsection

@section('content')
<div class="login-fullscreen">
  <div class="login-form-wrapper">
    <div class="text-center mb-4">
      <div class="login-icon-wrapper">
        <i class="bi bi-key-fill"></i>
      </div>
      <h2 class="mb-2">Reset Password</h2>
      <div class="text-muted-custom mb-4">Enter your email address and we'll send you a link to reset your password.</div>
    </div>

    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" role="alert">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{!! $error !!}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope-fill"></i></span>
        <input type="email" class="form-control form-control-dark" name="email" placeholder="Email Address" required value="{{ old('email') }}">
      </div>

      <button type="submit" class="btn btn-custom-primary w-100 mb-3">Send Reset Link</button>

      <div class="text-center">
        <small class="text-muted-custom">Remember your password? <a href="{{ route('login') }}" class="link-custom">Login here</a></small>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush 