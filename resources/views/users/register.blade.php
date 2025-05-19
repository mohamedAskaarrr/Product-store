@extends('layouts.master')
@section('title', 'Register')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-dark bg-gradient">
  <div class="card shadow-lg border-0 rounded-4 p-4 bg-secondary text-light" style="max-width: 370px; width: 100%;">
    <div class="text-center mb-4">
      <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
        <i class="bi bi-person-plus fs-1 text-light"></i>
      </div>
      <h2 class="fw-bold mb-1">Sign Up</h2>
      <div class="mb-3 text-secondary">Create your account to get started.</div>
    </div>
    <form action="{{route('do_register')}}" method="post">
      {{ csrf_field() }}
      @foreach($errors->all() as $error)
        <div class="alert alert-danger py-2 mb-2">
          <strong>Error!</strong> {{$error}}
        </div>
      @endforeach
      <div class="mb-3 input-group">
        <span class="input-group-text bg-dark border-0 text-light"><i class="bi bi-person"></i></span>
        <input type="text" class="form-control bg-dark text-light border-0" name="name" placeholder="Name" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text bg-dark border-0 text-light"><i class="bi bi-envelope"></i></span>
        <input type="email" class="form-control bg-dark text-light border-0" name="email" placeholder="Email" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text bg-dark border-0 text-light"><i class="bi bi-lock"></i></span>
        <input type="password" class="form-control bg-dark text-light border-0" name="password" placeholder="Password" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text bg-dark border-0 text-light"><i class="bi bi-lock"></i></span>
        <input type="password" class="form-control bg-dark text-light border-0" name="password_confirmation" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
      <div class="text-center mt-3">
        <small>Already have an account? <a href="{{ route('login') }}" class="link-primary">Login here</a></small>
      </div>
    </form>
  </div>
</div>
@endsection
@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection
