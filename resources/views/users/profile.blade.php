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
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card profile-card" data-aos="fade-right">
                <div class="card-body text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile" class="rounded-circle mb-3" width="120">
                    <h4 class="mb-3 text-gold">{{ $user->name }}</h4>
                    <p class="text-light mb-1">{{ $user->email }}</p>
                    <div class="mt-3">
                        @foreach($user->roles as $role)
                        <span class="badge bg-gold m-1">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card" data-aos="fade-left">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-gold">User Information</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th width="200">Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Credit Balance</th>
                                <td>
                                    <span class="badge bg-gold">${{ number_format($user->credit ?? 0, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Member Since</th>
                                <td>{{ $user->created_at ? $user->created_at->format('F j, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email Status</th>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-gold">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Not Verified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td>
                                    @foreach($user->roles as $role)
                                    <span class="badge bg-gold">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Permissions</th>
                                <td>
                                    @foreach($permissions as $permission)
                                    <span class="badge bg-gold">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-4">
                        @can('edit_users')
                        <a href="{{ route('users_edit', $user->id) }}" class="btn btn-gold me-2">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        @endcan
                        <a href="{{ route('edit_password', $user->id) }}" class="btn btn-gold">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
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

    .profile-card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }

    .table {
        background-color: #2c1e1e;
        color: #f5f5f5;
        border-color: #D4AF37;
    }

    .table th {
        background-color: #3a2a2a;
        color: #f5f5f5;
        border-bottom: 2px solid #D4AF37;
    }

    .table td {
        border-color: #D4AF37;
        color: #3a2a2a;
    }

    .badge.bg-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        font-weight: 500;
        padding: 6px 12px;
    }

    .text-gold {
        color: #D4AF37;
        font-weight: 600;
    }

    .card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
    }

    .btn-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background-color: #B38F28;
        color: #2c1e1e;
        transform: scale(1.05);
    }

    .text-light {
        color: #f5f5f5 !important;
    }

    .card-body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }
</style>
@endsection

</body>
</html>