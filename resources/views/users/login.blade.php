@extends('layouts.master')

@section('title', 'Login - NebulaAuth')

@section('head')
{{-- Bootstrap 5.3+ for better dark theme utilities and icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  :root {
    --primary-accent: #6f42c1; /* A deep purple, you can change this */
    --primary-accent-hover: #59359a;
    --dark-bg: #121212; /* Very dark background */
    --card-bg: #1e1e1e; /* Slightly lighter card background */
    --input-bg: #2a2a2a; /* Input field background */
    --border-color: #3a3a3a;
    --text-light: #e0e0e0;
    --text-muted-dark: #888;
  }

  body.login-page {
    background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1a1a 100%);
    color: var(--text-light);
  }

  .login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  .login-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem; /* Softer rounding */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 100%;
  }

  .login-card .card-body {
    padding: 2rem; /* More padding inside card */
  }

  .login-icon-wrapper {
    background-color: var(--input-bg); /* Use input bg for consistency */
    color: var(--primary-accent);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 0 15px rgba(var(--primary-accent-rgb, 111, 66, 193), 0.3); /* Dynamic shadow based on accent */
  }
  .login-icon-wrapper .bi {
    font-size: 2.5rem;
  }

  .login-card h2 {
    font-weight: 700;
    color: var(--text-light);
  }

  .login-card .text-muted-custom {
    color: var(--text-muted-dark) !important;
  }

  .form-control-dark {
    background-color: var(--input-bg) !important;
    color: var(--text-light) !important;
    border: 1px solid var(--border-color) !important;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
  }
  .form-control-dark::placeholder {
    color: var(--text-muted-dark);
  }
  .form-control-dark:focus {
    background-color: var(--input-bg) !important;
    border-color: var(--primary-accent) !important;
    box-shadow: 0 0 0 0.25rem rgba(var(--primary-accent-rgb, 111, 66, 193), 0.25);
    color: var(--text-light) !important;
  }

  .input-group-text-dark {
    background-color: var(--input-bg) !important;
    border: 1px solid var(--border-color) !important;
    border-right: none !important; /* Seamless look */
    color: var(--primary-accent) !important;
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
  }
  .input-group .form-control-dark {
      border-left: none !important; /* Seamless look */
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
  }
   .input-group:focus-within .input-group-text-dark { /* Highlight icon group on input focus */
    border-color: var(--primary-accent) !important;
    box-shadow: 0 0 0 0.25rem rgba(var(--primary-accent-rgb, 111, 66, 193), 0.25) inset;
    box-shadow: none; /* Override default to only rely on input's focus shadow */
  }


  .btn-custom-primary {
    background-color: var(--primary-accent);
    border-color: var(--primary-accent);
    color: #fff;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
  }
  .btn-custom-primary:hover {
    background-color: var(--primary-accent-hover);
    border-color: var(--primary-accent-hover);
    color: #fff;
  }

  .btn-outline-custom {
    border-color: var(--border-color);
    color: var(--text-light);
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out, border-color 0.15s ease-in-out;
  }
  .btn-outline-custom:hover {
    background-color: var(--primary-accent);
    border-color: var(--primary-accent);
    color: #fff;
  }

  .form-check-input-dark {
    background-color: var(--input-bg);
    border-color: var(--border-color);
  }
  .form-check-input-dark:checked {
    background-color: var(--primary-accent);
    border-color: var(--primary-accent);
  }
  .form-check-input-dark:focus {
    box-shadow: 0 0 0 0.25rem rgba(var(--primary-accent-rgb, 111, 66, 193), 0.25);
  }

  .link-custom {
    color: var(--primary-accent);
    text-decoration: none;
  }
  .link-custom:hover {
    color: var(--primary-accent-hover);
    text-decoration: underline;
  }
  .small-text-muted {
      color: var(--text-muted-dark) !important;
  }

  /* Helper to extract RGB from hex for box-shadow opacity */
  /* For this to work dynamically with :root vars, you'd typically need JS or SASS. */
  /* Hardcoding example for purple: --primary-accent-rgb: 111, 66, 193; */
  /* If you keep a fixed accent, you can set this value. */
  /* For demo, I'll assume purple #6f42c1 (111, 66, 193) for shadows */
  :root {
    --primary-accent-rgb: 111, 66, 193; /* For #6f42c1 */
  }

</style>
@endsection

@section('content')
<div class="login-container">
  <div class="login-card">
    <div class="card-body">
      <div class="text-center mb-4">
        <div class="login-icon-wrapper">
          <i class="bi bi-shield-lock-fill"></i> {{-- Changed icon for a more "secure login" feel --}}
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