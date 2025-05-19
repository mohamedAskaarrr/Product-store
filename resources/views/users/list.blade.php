@extends('layouts.master')

@section('title', 'Users List')

@section('content')

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="text-gold"><i class="fas fa-users me-2"></i>Users List</h2>
        </div>
        <div class="col-md-6 text-end">
            @can('admin_users')
            <a href="{{ route('users_create') }}" class="btn btn-gold mb-3">
                <i class="fas fa-user-plus"></i> Add New User
            </a>
            @endcan
            <form action="{{ route('users') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="keywords" class="form-control" placeholder="Search users..." value="{{ request()->keywords }}">
                <button type="submit" class="btn btn-gold">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                        <span class="badge bg-gold">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('profile', $user->id) }}" class="btn btn-gold btn-sm me-2">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @can('edit_users')
                            <a href="{{ route('users_edit', $user->id) }}" class="btn btn-gold btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @endcan
                            @can('delete_users')
                            <form action="{{ route('users_delete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-gold btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Navigation Bar Styling */
    .navbar {
        background-color: #2c1e1e !important;
    }

    .nav-link {
        color: #f5f5f5 !important;
        font-weight: 500;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .nav-link:hover {
        color: #D4AF37 !important;
        transform: translateY(-2px);
    }

    .navbar-brand {
        color: #D4AF37 !important;
    }

    .dropdown-menu {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
    }

    .dropdown-item {
        color: #f5f5f5;
    }

    .dropdown-item:hover {
        background-color: #D4AF37;
        color: #2c1e1e;
    }

    /* Page Styling */
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }

    /* Table Styling */
    .table {
        background-color: #7a6b6b !important;
        color: #f5f5f5 !important;
        border-color: #D4AF37 !important;
    }

    .table thead th {
        background-color: #7a6b6b !important;
        color: #f5f5f5 !important;
        border-color: #D4AF37 !important;
        font-weight: 600;
    }

    .table tbody tr {
        background-color: #7a6b6b !important;
        border-color: #D4AF37 !important;
    }

    .table tbody tr:hover {
        background-color: #8a7b7b !important;
    }

    .table td {
        color: #7a6b6b !important;
        border-color: #D4AF37 !important;
    }

    /* Form Controls */
    .form-control {
        background-color: #3a2a2a;
        border-color: #D4AF37;
        color: #f5f5f5;
    }

    .form-control:focus {
        background-color: #3a2a2a;
        border-color: #D4AF37;
        color: #f5f5f5;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }

    /* Button Styling */
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

    /* Container and Layout */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

@endsection

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        /* Overall body and page style */
        body {
            background-color: #f8f9fa; /* Light background for the whole page */
            font-family: 'Arial', sans-serif;
        }

        .container {
            padding: 30px;
        }

        /* Card styling */
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            font-size: 16px;
        }

        table th {
            background-color: #28a745;
            color: white;
        }

        table td {
            background-color: #f8f9fa;
        }

        table tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        /* Button hover effects */
        .btn-primary:hover, .btn-warning:hover, .btn-danger:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        /* Badge styling for roles */
        .badge {
            font-size: 14px;
            margin: 0 5px;
        }

        /* Search bar and button styles */
        .form-control {
            border-radius: 25px;
            box-shadow: none;
        }

        .btn-success, .btn-danger {
            border-radius: 25px;
            width: 100%;
        }

        /* Spacing adjustments */
        .row.mb-4 {
            margin-bottom: 20px;
        }
    </style>
@endsection
