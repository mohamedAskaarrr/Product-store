<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>

    <!-- FontAwesome Icons for use in buttons and links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Additional Styling -->
    <style>
        /* Soft Green Background */
        body {
            background: linear-gradient(135deg, #a8d08d 0%, #81c784 100%); /* Soft Green Gradient */
            font-family: 'Arial', sans-serif;
            padding-top: 20px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Transparent White for contrast */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #388e3c;
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #76d7c4;
            box-shadow: 0 0 5px rgba(118, 215, 196, 0.8);
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        button {
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            transition: transform 0.3s ease, background-color 0.4s ease;
            background-color: #388e3c;
            color: white;
            border: none;
        }

        button:hover {
            transform: scale(1.05);
            background-color: #66bb6a;
        }

        button i {
            margin-right: 10px;
        }

        /* Reset links */
        a#clean_roles, a#clean_permissions {
            color: #d32f2f;
            font-size: 14px;
            text-decoration: none;
        }

        a#clean_roles:hover, a#clean_permissions:hover {
            text-decoration: underline;
        }

        /* Alert messages */
        .alert-danger {
            font-size: 14px;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
        }

        /* Adjust margins for responsive layouts */
        @media (max-width: 768px) {
            .col-12 {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>
</head>
<body>
@extends('layouts.master')

@section('title', 'Edit User')

@section('content')

<!-- Include jQuery for reset buttons -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#clean_permissions").click(function(){
    $('#permissions').val([]);
  });
  $("#clean_roles").click(function(){
    $('#roles').val([]);
  });
  
  // Reset Credit Button
  $("#reset-credit-btn").click(function(){
    const userId = $(this).data('user-id');
    if(confirm('Are you sure you want to reset this user\'s credit to 0?')) {
      $.ajax({
        url: '/users/reset-credit/' + userId,
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if(response.success) {
            alert('Credit reset successfully!');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr) {
          alert('Error: ' + xhr.responseJSON.message);
        }
      });
    }
  });
  
  // Add Credit Form Submit
  $("#add-credit-form").submit(function(e){
    e.preventDefault();
    const userId = $(this).data('user-id');
    const creditAmount = $(this).find('input[name="credit"]').val();
    
    if(creditAmount <= 0) {
      alert('Please enter a positive credit amount');
      return;
    }
    
    $.ajax({
      url: '/users/add-credit/' + userId,
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        credit: creditAmount
      },
      success: function(response) {
        if(response.success) {
          alert('Credit added successfully!');
          location.reload();
        } else {
          alert('Error: ' + response.message);
        }
      },
      error: function(xhr) {
        alert('Error: ' + xhr.responseJSON.message);
      }
    });
  });
});
</script>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" data-aos="fade-up">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit User</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users_save', $user->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        @can('manage_customer_credit')
                        <div class="form-group mb-3">
                            <label for="credit" class="form-label">Credit Management</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="credit" name="credit" min="0" step="0.01" value="{{ old('credit', $user->credit) }}" required>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Current credit balance: ${{ number_format($user->credit, 2) }}</small>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('credit').value = '0'">
                                    Reset Credit
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="form-group mb-3">
                            <label class="form-label">Credit Balance</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" value="{{ number_format($user->credit, 2) }}" readonly>
                            </div>
                        </div>
                        @endcan

                        @if(Auth::user()->hasPermissionTo('admin_users'))
                        <div class="form-group mb-4">
                            <label class="form-label d-block">Roles</label>
                            @foreach($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[]" 
                                           value="{{ $role->name }}" id="role_{{ $role->id }}"
                                           {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label d-block">Permissions</label>
                            @foreach($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                           value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                                           {{ $permission->taken ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->display_name ?? $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            @if(auth()->user()->hasPermissionTo('show_users'))
                                <a href="{{ route('users') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background-color: var(--card-bg);
        border: none;
        box-shadow: var(--card-shadow);
    }

    .form-control {
        background-color: var(--input-bg);
        border-color: var(--border-color);
        color: var(--text-color);
    }

    .form-control:focus {
        background-color: var(--input-bg);
        border-color: var(--primary-color);
        color: var(--text-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
    }

    .form-label {
        color: var(--text-color);
        font-weight: 500;
    }

    .form-check-label {
        color: var(--text-color);
    }

    .form-check-input {
        background-color: var(--input-bg);
        border-color: var(--border-color);
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .alert-danger {
        background-color: var(--danger-bg);
        border-color: var(--danger-color);
        color: var(--danger-text);
    }

    .btn {
        border-radius: 6px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card-title {
        color: var(--primary-color);
        font-weight: 600;
    }
</style>
@endsection

</body>
</html>















