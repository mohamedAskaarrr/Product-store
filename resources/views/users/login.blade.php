@extends('layouts.master')

@section('title', 'Login - NebulaAuth')

@section('head')
{{-- Bootstrap 5.3+ for better dark theme utilities and icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #2c1e1e;
    color: #fffbe6;
    overflow-x: hidden;
  }
  .login-fullscreen {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    width: 100%;
  }
  .login-form-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 400px;
    background: #2c1e1e;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    padding: 2.5rem 2rem 2rem 2rem;
    border: 1.5px solid #D4AF37;
  }
  .login-icon-wrapper {
    background: linear-gradient(135deg, #2c261e 60%, #3a3326 100%);
    color: #ffd700;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 0 32px 0 rgba(255, 215, 0, 0.2);
  }
  .login-icon-wrapper .bi {
    font-size: 2.5rem;
  }
  .login-form-wrapper h2 {
    font-weight: 800;
    color: #fff;
    letter-spacing: 1px;
  }
  .login-form-wrapper .text-muted-custom {
    color: #d4c091 !important;
  }
  .form-control-dark {
    background: rgba(44, 30, 30, 0.8) !important;
    color: #fffbe6 !important;
    border: 1.5px solid #D4AF37 !important;
    border-radius: 0.5rem;
    padding: 0.85rem 1.1rem;
  }
  .form-control-dark:focus {
    border-color: #ffd700 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.2);
    background: rgba(50, 45, 35, 0.9) !important;
  }
  .input-group-text-dark {
    background: rgba(40, 35, 25, 0.8) !important;
    border: 1.5px solid rgba(255, 215, 0, 0.2) !important;
    color: #ffd700 !important;
  }
  .btn-custom-primary {
    background: linear-gradient(90deg, #ffd700 0%, #daa520 100%);
    border: none;
    color: #1a1814;
    font-weight: 600;
  }
  .btn-custom-primary:hover {
    background: linear-gradient(90deg, #daa520 0%, #ffd700 100%);
    color: #1a1814;
  }
  .btn-outline-custom {
    border: 1.5px solid rgba(255, 215, 0, 0.3);
    color: #ffd700;
  }
  .btn-outline-custom:hover {
    background: rgba(255, 215, 0, 0.1);
    border-color: #ffd700;
    color: #ffd700;
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
</style>
@endsection

@section('content')
<div class="login-fullscreen">
  <div class="login-form-wrapper">
    <div class="text-center mb-4">
      <div class="login-icon-wrapper">
        <i class="bi bi-shield-lock-fill"></i>
      </div>
      <h2 class="mb-2">Sign In</h2>
      <div class="text-muted-custom mb-4">Welcome back! Please sign in to continue.</div>
    </div>
    <form action="{{route('do_login')}}" method="post">
      {{ csrf_field() }}
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
        <input type="email" class="form-control form-control-dark" name="email" placeholder="Email Address" required value="{{ old('email') }}">
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-key-fill"></i></span>
        <input type="password" class="form-control form-control-dark" name="password" placeholder="Password" required>
      </div>
      <div class="d-flex justify-content-between align-items-center my-3">
        <div class="form-check">
          <input class="form-check-input form-check-input-dark" type="checkbox" name="remember" id="rememberMe">
          <label class="form-check-label small" for="rememberMe">Remember me</label>
        </div>
        <a href="#" class="link-custom small">Forgot password?</a>
      </div>
      <button type="submit" class="btn btn-custom-primary w-100 mb-3">Sign In</button>
      <a href="{{route('login_with_google')}}" class="btn btn-outline-custom w-100 mb-3">
        <i class="bi bi-google me-2"></i>Sign in with Google
      </a>
      <div class="text-center mt-4">
        <small class="small-text-muted">Don't have an account? <a href="{{ route('register') }}" class="link-custom fw-medium">Register here</a></small>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Optional: If you change --primary-accent in JS, you can update --primary-accent-rgb
  // For simplicity, it's hardcoded in CSS or set once.
  // Example: to dynamically set --primary-accent-rgb if you allow theme switching
  function updateAccentRgb() {
    const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-accent').trim();
    if (accentColor.startsWith('#')) {
      const r = parseInt(accentColor.slice(1, 3), 16);
      const g = parseInt(accentColor.slice(3, 5), 16);
      const b = parseInt(accentColor.slice(5, 7), 16);
      document.documentElement.style.setProperty('--primary-accent-rgb', `${r}, ${g}, ${b}`);
    }
  }
  // updateAccentRgb(); // Call if needed
</script>
@endpush