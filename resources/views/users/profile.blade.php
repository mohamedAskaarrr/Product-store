<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    
    <!-- Link to the Favicon -->
    <link rel="icon" href="{{ asset('images/4.jpeg/') }}" type="image/svg+xml">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

@extends('layouts.master')
@section('title', 'User Profile')

@section('content')
<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card profile-card shadow-lg border-0 rounded-4 p-4">
                <div class="row g-0 align-items-center">
                    <!-- Left: Avatar & Basic Info -->
                    <div class="col-md-5 text-center border-end border-gold pe-4 mb-4 mb-md-0">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                             alt="Profile" class="rounded-circle mb-3 border border-3 border-gold"
                             width="120" height="120">
                        <h3 class="mb-0 text-gold">{{ $user->name }}</h3>
                        <p class="text-light mb-2">{{ $user->email }}</p>
                        <div class="mb-3">
                            @foreach($user->roles as $role)
                                <span class="badge bg-gold text-dark me-1">{{ $role->name }}</span>
                            @endforeach
                            @if(isset($user->credit))
                                <span class="badge bg-gold text-dark ms-1">
                                    <i class="fas fa-wallet me-1"></i>${{ number_format($user->credit, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Right: Actions & Permissions -->
                    <div class="col-md-7 ps-md-4 pt-4 pt-md-0">
                        <div class="d-flex flex-wrap justify-content-start gap-2 mb-4">
                            @if(auth()->id() == $user->id || auth()->user()->hasPermissionTo('edit_users'))
                            <a href="{{ route('users_edit', $user->id) }}" class="btn btn-outline-gold">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                            @endif
                            <a href="{{ route('edit_password', $user->id) }}" class="btn btn-outline-gold">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                            <a href="{{ route('purchase_history', $user->id) }}" class="btn btn-outline-gold">
                                <i class="fas fa-history"></i> Purchase History
                            </a>
                            @role('Admin')
                            <a href="{{ route('fav') }}" class="btn btn-outline-gold">
                                <i class="fas fa-heart"></i> Favourites
                            </a>
                            @endrole
                        </div>
                        <h6 class="text-uppercase text-gold mb-2">Permissions</h6>
                        <div class="mb-2">
                            @php
                                $permissionCategories = [
                                    'Product Management' => ['add_products', 'edit_products', 'delete_products', 'view_products', 'manage_inventory'],
                                    'User Management' => ['show_users', 'edit_users', 'delete_users', 'admin_users', 'view_customers'],
                                    'Sales & Finance' => ['purchase_products', 'view_sales', 'manage_customer_credit', 'manage_refunds'],
                                    'Promotions' => ['manage_promotions']
                                ];
                            @endphp

                            @foreach($permissionCategories as $category => $permissions)
                                <div class="mb-3">
                                    <h6 class="text-gold mb-2">{{ $category }}</h6>
                                    <div class="d-flex flex-wrap gap-2">
                            @foreach($permissions as $permission)
                                            @if($user->hasPermissionTo($permission))
                                                <span class="badge bg-dark text-gold border border-gold">
                                                    {{ str_replace('_', ' ', ucfirst($permission)) }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.5s ease forwards;
}
@media (max-width: 767.98px) {
    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
}

body, .profile-card, .container {
    background-color: #2c1e1e !important;
    color: #fffbe6;
}
.profile-card {
    background-color: #2c1e1e;
    border: 2px solid #D4AF37;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(212, 175, 55, 0.10), 0 1.5px 4px rgba(0,0,0,0.10);
}
.text-gold {
    color: #D4AF37 !important;
}
.bg-gold {
    background-color: #D4AF37 !important;
    color: #2c1e1e !important;
}
.border-gold {
    border-color: #D4AF37 !important;
}
.btn-gold {
    background: #D4AF37 !important;
    color: #2c1e1e !important;
    border: 2px solid #D4AF37 !important;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: all 0.3s;
}
.btn-gold:hover, .btn-gold:focus {
    background: #2c1e1e !important;
    color: #D4AF37 !important;
    border: 2px solid #D4AF37 !important;
}
.btn-outline-gold {
    background: transparent !important;
    border: 2px solid #D4AF37 !important;
    color: #D4AF37 !important;
    border-radius: 0.5rem;
    transition: all 0.3s;
}
.btn-outline-gold:hover, .btn-outline-gold:focus {
    background: #D4AF37 !important;
    color: #2c1e1e !important;
    border: 2px solid #D4AF37 !important;
}
.badge.bg-dark {
    background: #1e1e1e !important;
    color: #D4AF37 !important;
    border: 1.5px solid #D4AF37;
}
@media (max-width: 767.98px) {
    .profile-card .row.g-0 {
        flex-direction: column;
    }
    .profile-card .border-end {
        border: none !important;
        border-bottom: 2px solid #D4AF37 !important;
        margin-bottom: 2rem;
        padding-right: 0 !important;
    }
    .profile-card .ps-md-4 {
        padding-left: 0 !important;
    }
}
</style>
@endsection

@push('head')
<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endpush

</body>
</html>