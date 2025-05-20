@extends('layouts.master')

@section('title', 'Login - NebulaAuth')

@section('head')
{{-- Bootstrap 5.3+ for better dark theme utilities and icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  html, body {
    background: #000 !important;
    height: 100%;
    margin: 0;
    padding: 0;
    color: #e0e0e0;
    overflow: hidden;
  }
  .login-fullscreen {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100vw;
    background: #000;
  }
  .login-left {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000 !important;
    z-index: 2;
  }
  .login-form-wrapper {
    width: 100%;
    max-width: 400px;
    background: #111 !important;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px 0 #000a;
    padding: 2.5rem 2rem 2rem 2rem;
    border: 1.5px solid #222 !important;
    color: #fff;
  }
  .login-icon-wrapper {
    background: linear-gradient(135deg, #1a1a2a 60%, #2a2a4a 100%);
    color: #a084fa;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 0 32px 0 #a084fa44;
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
    color: #b0b0c0 !important;
  }
  .form-control-dark {
    background: #18181c !important;
    color: #e0e0fa !important;
    border: 1.5px solid #23234a !important;
    border-radius: 0.5rem;
    padding: 0.85rem 1.1rem;
    font-size: 1.05rem;
    box-shadow: 0 2px 8px 0 #0002;
  }
  .form-control-dark:focus {
    border-color: #a084fa !important;
    box-shadow: 0 0 0 0.2rem #a084fa33;
    background: #23234a !important;
    color: #fff !important;
  }
  .input-group-text-dark {
    background: #18181c !important;
    border: 1.5px solid #23234a !important;
    color: #a084fa !important;
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
  }
  .btn-custom-primary {
    background: linear-gradient(90deg, #a084fa 0%, #6247ea 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 16px 0 #a084fa33;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .btn-custom-primary:hover {
    background: linear-gradient(90deg, #6247ea 0%, #a084fa 100%);
    box-shadow: 0 4px 24px 0 #a084fa55;
  }
  .btn-outline-custom {
    border: 1.5px solid #23234a;
    color: #e0e0fa;
    background: transparent;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }
  .btn-outline-custom:hover {
    background: #23234a;
    color: #fff;
    border-color: #a084fa;
  }
  .form-check-input-dark {
    background: #23234a;
    border-color: #23234a;
  }
  .form-check-input-dark:checked {
    background: #a084fa;
    border-color: #a084fa;
  }
  .link-custom {
    color: #a084fa;
    text-decoration: none;
    font-weight: 500;
  }
  .link-custom:hover {
    color: #fff;
    text-decoration: underline;
  }
  .small-text-muted {
    color: #b0b0c0 !important;
  }
</style>
@endsection

@section('content')
<div class="login-fullscreen">
  <div class="login-left">
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
</div>
@endsection

@push('scripts')
{{-- Add this to your master layout if you don't have it, or just include BS JS here --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
<script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.96/build/spline-viewer.js"></script>
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