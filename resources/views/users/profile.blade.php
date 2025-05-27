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
                        <h3 class="mb-0 text-gold">{{ $user->name }}
                            @if(auth()->user()->hasRole('Admin') && !$user->email_verified_at)
                                <form action="{{ route('users.admin_verify', $user->id) }}" method="POST" style="display:inline; margin-left: 8px;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Verify this account" style="padding:2px 8px; font-size:0.9em;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </h3>
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
                            <a href="{{ route('fav') }}" class="btn btn-outline-gold">
                                <i class="fas fa-heart"></i> Favourites
                            </a>
                            @if(auth()->id() == $user->id)
                            <button type="button" class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#creditRequestModal">
                                <i class="fas fa-credit-card"></i> Request Credit
                            </button>
                            @endif
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

<!-- Credit Request Modal -->
@if(auth()->id() == $user->id)
<div class="modal fade" id="creditRequestModal" tabindex="-1" aria-labelledby="creditRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-gold">
            <form method="POST" action="{{ route('credit.request.submit') }}">
                @csrf
                <div class="modal-header border-gold">
                    <h5 class="modal-title" id="creditRequestModalLabel">
                        <i class="fas fa-credit-card me-2"></i>Request Credit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label text-gold">Amount ($)</label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               min="1" max="100000" step="0.01" required 
                               placeholder="Enter amount (max $100,000)">
                        <div class="form-text text-light">Current balance: ${{ number_format($user->credit, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label text-gold">Reason (Optional)</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" 
                                  maxlength="1000" placeholder="Please explain why you need this credit..."></textarea>
                        <div class="form-text text-light">Help us understand your request better (optional)</div>
                    </div>
                    <div class="alert alert-info border-gold bg-transparent text-light">
                        <i class="fas fa-info-circle me-2"></i>
                        Your request will be sent to the admin for review. You will be notified once it's processed.
                    </div>
                </div>
                <div class="modal-footer border-gold">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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
/* Extra mobile tweaks for xs screens */
@media (max-width: 576px) {
    .container.py-5 {
        padding: 0.5rem !important;
    }
    .profile-card {
        padding: 1rem !important;
        border-radius: 10px !important;
    }
    .profile-card img.rounded-circle {
        width: 70px !important;
        height: 70px !important;
    }
    .profile-card h3 {
        font-size: 1.1rem !important;
    }
    .profile-card .btn, .profile-card .btn-outline-gold {
        width: 100% !important;
        margin-bottom: 0.5rem !important;
        font-size: 1rem !important;
        padding: 0.7rem 1rem !important;
    }
    .profile-card .d-flex.flex-wrap.gap-2.mb-4 {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
    .profile-card .badge {
        font-size: 0.95rem !important;
        padding: 0.4em 0.7em !important;
        margin-bottom: 0.2em !important;
    }
    .profile-card .mb-3, .profile-card .mb-2 {
        margin-bottom: 0.7rem !important;
    }
    .profile-card .d-flex.flex-wrap.gap-2 {
        gap: 0.3rem !important;
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

/* Modal Styles */
.modal-content {
    background-color: #2c1e1e !important;
    border: 1px solid #D4AF37;
}
.modal-header {
    border-bottom-color: #D4AF37;
}
.modal-footer {
    border-top-color: #D4AF37;
}
.btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
}
.form-control {
    background-color: #2c1e1e !important;
    border-color: #D4AF37 !important;
    color: #f5f5f5 !important;
    transition: all 0.3s ease;
}
.form-control:focus {
    background-color: #3a2a2a !important;
    border-color: #D4AF37 !important;
    color: #f5f5f5 !important;
    box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
}
.border-gold {
    border-color: #D4AF37 !important;
}
</style>
@endsection

@push('head')
<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endpush

</body>
</html>