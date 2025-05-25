@extends('layouts.master')

@section('title', 'Users List')

@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1 class="text-gold mb-0">
                        <i class="fas fa-users"></i> Users
                        <small class="text-light d-block mt-2" style="font-size: 1rem;">Manage system users</small>
                    </h1>
                </div>
                <div class="col-md-6 text-end">
                    @can('admin_users')
                    <a href="{{ route('users_create') }}" class="btn btn-gold mb-3">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                    @endcan
                    <form action="{{ route('users') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="keywords" class="form-control bg-dark text-light border-gold" placeholder="Search users..." value="{{ request()->keywords }}">
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th class="border-gold">Name</th>
                            <th class="border-gold">Email</th>
                            <th class="border-gold">Credit</th>
                            <th class="border-gold">Roles</th>
                            <th class="border-gold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="border-gold">{{ $user->name }}</td>
                            <td class="border-gold">{{ $user->email }}</td>
                            <td class="border-gold">
                                <span class="badge bg-credit">${{ number_format($user->credit, 2) }}</span>
                            </td>
                            <td class="border-gold">
                                @foreach($user->roles as $role)
                                    @if($role->name === 'Admin')
                                        <span class="badge bg-admin">{{ $role->name }}</span>
                                    @elseif($role->name === 'Employee')
                                        <span class="badge bg-employee">{{ $role->name }}</span>
                                    @elseif($role->name === 'Supplier')
                                        <span class="badge bg-supplier">{{ $role->name }}</span>
                                    @elseif($role->name === 'Manager')
                                        <span class="badge bg-manager">{{ $role->name }}</span>
                                    @else
                                        <span class="badge bg-customer">{{ $role->name }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="border-gold">
                                <div class="btn-group">
                                    <a href="{{ route('profile', $user->id) }}" class="btn btn-view btn-sm me-2">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @can('edit_users')
                                    <a href="{{ route('users_edit', $user->id) }}" class="btn btn-edit btn-sm me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endcan
                                    @can('delete_users')
                                    <form action="{{ route('users_delete', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
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
    </div>
</div>

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }
    .table-dark {
        background-color: #2c1e1e !important;
        color: #f5f5f5 !important;
    }
    .table-dark thead th {
        background-color: #3a2a2a !important;
        color: #D4AF37 !important;
        border-color: #D4AF37 !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-dark tbody tr {
        background-color: #2c1e1e !important;
        border-color: #D4AF37 !important;
        transition: all 0.3s ease;
    }
    .table-dark tbody tr:hover {
        background-color: #3a2a2a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.1);
    }
    .table-dark td {
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        vertical-align: middle;
    }
    .border-gold {
        border-color: #D4AF37 !important;
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
    .btn-view {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .btn-edit {
        background-color: #E5C158 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .btn-delete {
        background-color: #f9cf6e !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .badge.bg-admin {
        background-color: #8B6914 !important;
        color: #f5f5f5 !important;
    }
    .badge.bg-employee {
        background-color: #B38F28 !important;
        color: #f5f5f5 !important;
    }
    .badge.bg-supplier {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-manager {
        background-color: #E5C158 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-customer {
        background-color: #F5D280 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-credit {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
    }
    .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
        color: #2c1e1e !important;
        opacity: 0.9;
    }
    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .text-gold {
        color: #D4AF37 !important;
        font-weight: 600;
    }
    .text-light {
        color: #f5f5f5 !important;
    }
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #D4AF37;
    }
    .btn-gold {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn-gold:hover {
        background-color: #B38F28 !important;
        color: #2c1e1e !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }
    @media (max-width: 576px) {
        .container.py-4 {
            padding: 0.5rem !important;
        }
        .row.mb-4 > .col-md-6, .row.mb-4 > .col-md-6.text-end {
            flex: 0 0 100%;
            max-width: 100%;
            text-align: left !important;
            margin-bottom: 0.5rem !important;
        }
        .row.mb-4 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        .d-flex.gap-2, .d-flex {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        .btn,
        .btn-gold,
        .btn-view,
        .btn-edit,
        .btn-delete {
            width: 100% !important;
            font-size: 1rem !important;
            padding: 0.7rem 1rem !important;
            margin-bottom: 0.5rem !important;
        }
        .btn-group, .d-flex.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        .badge {
            font-size: 0.95rem !important;
            padding: 0.4em 0.7em !important;
            margin-bottom: 0.2em !important;
        }
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .table {
            min-width: 600px !important;
            font-size: 0.95rem !important;
        }
        .form-control {
            font-size: 1rem !important;
            padding: 0.7rem 1rem !important;
        }
        form.d-flex.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
    }
</style>

@endsection

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const creditForms = document.querySelectorAll('[id^="add-credit-form-"]');
    creditForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Credit added successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        });
    });
});
</script>
@endpush
