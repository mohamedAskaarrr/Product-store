@extends('layouts.master')
@section('title', 'Register')
@section('head')
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
  .register-fullscreen {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    width: 100vw;
    background: #000;
  }
  .register-form-wrapper {
    width: 100%;
    max-width: 400px;
    background: #111 !important;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px 0 #000a;
    padding: 2.5rem 2rem 2rem 2rem;
    border: 1.5px solid #222 !important;
    color: #fff;
  }
  .register-icon-wrapper {
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
  .register-icon-wrapper .bi {
    font-size: 2.5rem;
  }
  .register-form-wrapper h2 {
    font-weight: 800;
    color: #fff;
    letter-spacing: 1px;
  }
  .register-form-wrapper .text-muted-custom {
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
<div class="register-fullscreen">
  <div class="register-form-wrapper">
    <div class="text-center mb-4">
      <div class="register-icon-wrapper">
        <i class="bi bi-person-plus"></i>
      </div>
      <h2 class="mb-2">Sign Up</h2>
      <div class="text-muted-custom mb-4">Create your account to get started.</div>
    </div>
    <form action="{{route('do_register')}}" method="post">
      {{ csrf_field() }}
      @foreach($errors->all() as $error)
        <div class="alert alert-danger py-2 mb-2">
          <strong>Error!</strong> {{$error}}
        </div>
      @endforeach
      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-person"></i></span>
        <input type="text" class="form-control form-control-dark" name="name" placeholder="Name" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope"></i></span>
        <input type="email" class="form-control form-control-dark" name="email" placeholder="Email" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-lock"></i></span>
        <input type="password" class="form-control form-control-dark" name="password" placeholder="Password" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text input-group-text-dark"><i class="bi bi-lock"></i></span>
        <input type="password" class="form-control form-control-dark" name="password_confirmation" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-custom-primary w-100 mb-3">Register</button>
      <div class="text-center mt-3">
        <small class="small-text-muted">Already have an account? <a href="{{ route('login') }}" class="link-custom">Login here</a></small>
      </div>
    </form>
  </div>
</div>
@endsection
