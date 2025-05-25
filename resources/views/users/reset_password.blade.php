@extends('layouts.master')

@section('title', 'Reset Password - NebulaAuth')

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
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid #D4AF37;
    box-shadow: 0 0 24px 0 rgba(212,175,55,0.10);
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
    color: #f5f5f5 !important;
    border: 1px solid #D4AF37 !important;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
  }

  .form-control-dark::placeholder {
    color: #f5f5f5 !important;
    opacity: 0.7;
  }

  .form-control-dark:focus {
    border-color: #D4AF37 !important;
    box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
    background: #3a2a2a !important;
  }

  .input-group-text-dark {
    background: #2c1e1e !important;
    border: 1px solid #D4AF37 !important;
    color: #D4AF37 !important;
    border-radius: 0.5rem 0 0 0.5rem;
    padding: 0.75rem 1rem;
  }

  .btn-custom-primary {
    background: #D4AF37 !important;
    border: none !important;
    color: #2c1e1e !important;
    font-weight: 600;
    transition: all 0.3s ease;
    border-radius: 20px;
    padding: 8px 16px;
  }

  .btn-custom-primary:hover, .btn-custom-primary:focus {
    background: #B38F28 !important;
    color: #2c1e1e !important;
    border: none !important;
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
  }

  .link-custom {
    color: #D4AF37;
  }

  .link-custom:hover {
    color: #E5C158;
  }

  .text-muted-custom {
    color: #f5f5f5 !important;
    opacity: 0.8;
  }

  .alert-danger {
    background: #2c1e1e;
    border-color: #D4AF37;
    color: #f5f5f5;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
  }

  .alert-danger ul {
    margin-bottom: 0;
    padding-left: 1.25rem;
  }

  .alert-danger li {
    margin-bottom: 0.25rem;
  }

  .alert-danger li:last-child {
    margin-bottom: 0;
  }

  .btn-close.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
  }

  @media (max-width: 576px) {
    .login-form-wrapper {
      padding: 1rem !important;
      border-radius: 1rem !important;
      max-width: 98vw !important;
    }
    .login-icon-wrapper {
      width: 56px !important;
      height: 56px !important;
      font-size: 1.2rem !important;
      margin-bottom: 1rem !important;
    }
    .login-icon-wrapper .bi {
      font-size: 1.5rem !important;
    }
    h2.mb-2 {
      font-size: 1.5rem !important;
      margin-bottom: 0.5rem !important;
    }
    .text-muted-custom.mb-4 {
      margin-bottom: 1rem !important;
    }
    .form-control-dark, .input-group-text-dark {
      font-size: 0.9rem !important;
      padding: 0.5rem 0.8rem !important;
    }
    .btn-custom-primary {
      font-size: 0.9rem !important;
      padding: 0.5rem 1rem !important;
      border-radius: 20px !important;
    }
    .login-fullscreen {
      align-items: flex-start !important;
      padding-top: 2rem !important;
      height: 100vh !important;
    }
  }
</style>
@endsection

@section('content')
<div class="login-fullscreen">
  <div class="login-form-wrapper">
    <div class="text-center mb-4">
      <div class="login-icon-wrapper">
        <i class="bi bi-shield-lock-fill"></i>
      </div>
      <h2 class="mb-2">Reset Password</h2>
      <div class="text-muted-custom mb-4">Enter your new password below.</div>
    </div>

    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

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

      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope-fill"></i></span>
        <input type="email" class="form-control form-control-dark" name="email" placeholder="Email Address" required value="{{ $email ?? old('email') }}">
      </div>

      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-key-fill"></i></span>
        <input type="password" class="form-control form-control-dark" name="password" placeholder="New Password" required>
      </div>

      <div class="mb-4 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-key-fill"></i></span>
        <input type="password" class="form-control form-control-dark" name="password_confirmation" placeholder="Confirm New Password" required>
      </div>

      <button type="submit" class="btn btn-custom-primary w-100 mb-3">Reset Password</button>

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