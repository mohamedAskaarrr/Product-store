@extends('layouts.master')
@section('title', 'Edit Password')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-gold" data-aos="fade-up">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-gold">Change Password</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('save_password', $user->id)}}" method="post">
                        @csrf
                        @if(!auth()->user()->hasPermissionTo('admin_users') || auth()->id()==$user->id)
                            <div class="mb-3">
                                <label class="form-label text-gold">Old Password</label>
                                <input type="password" class="form-control bg-dark text-light border-gold" name="old_password" required>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label text-gold">New Password</label>
                            <input type="password" class="form-control bg-dark text-light border-gold" name="password" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-gold">Confirm New Password</label>
                            <input type="password" class="form-control bg-dark text-light border-gold" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-gold">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }
    .card {
        border: 1px solid #D4AF37;
        border-radius: 1rem;
        box-shadow: 0 0 24px 0 rgba(212,175,55,0.10);
    }
    .form-control {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37 !important;
        color: #f5f5f5 !important;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background-color: #3a2a2a !important;
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
    }
    .btn-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        border: none;
        transition: all 0.3s ease;
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 20px;
    }
    .btn-gold:hover {
        background-color: #B38F28;
        color: #2c1e1e;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }
    .alert-danger {
        background-color: #2c1e1e;
        border-color: #D4AF37;
        color: #f5f5f5;
    }
    .text-gold {
        color: #D4AF37;
    }
    .border-gold {
        border-color: #D4AF37 !important;
    }
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
    }
</style>
@endsection