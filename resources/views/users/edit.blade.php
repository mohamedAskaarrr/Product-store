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
        /* Remove green background, use theme */
        body {
            background-color: #2c1e1e !important;
            color: #D4AF37 !important;
            font-family: 'Arial', sans-serif;
            padding-top: 20px;
        }
        .container {
            background: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            color: #D4AF37 !important;
        }
        h1 {
            color: #D4AF37 !important;
            font-weight: bold;
        }
        .form-control {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #2c1e1e !important;
            color: #D4AF37 !important;
            border: 1px solid #D4AF37 !important;
        }
        .form-control:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.15);
            color: #D4AF37 !important;
        }
        .form-label {
            font-weight: 500;
            color: #D4AF37 !important;
        }
        button {
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            transition: transform 0.3s ease, background-color 0.4s ease;
            background-color: #D4AF37 !important;
            color: #2c1e1e !important;
            border: none;
        }
        button:hover {
            transform: scale(1.05);
            background-color: #2c1e1e !important;
            color: #D4AF37 !important;
            border: 1px solid #D4AF37 !important;
        }
        button i {
            margin-right: 10px;
        }
        a#clean_roles, a#clean_permissions {
            color: #d32f2f;
            font-size: 14px;
            text-decoration: none;
        }
        a#clean_roles:hover, a#clean_permissions:hover {
            text-decoration: underline;
        }
        .alert-danger {
            font-size: 14px;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
            background-color: #2c1e1e !important;
            border: 1px solid #D4AF37 !important;
            color: #D4AF37 !important;
        }
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

<div class="container py-4 main-bg">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card edit-card" data-aos="fade-up">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-gold">Edit User
                        @if(auth()->user()->hasRole('Admin') && !$user->email_verified_at)
                            <form action="{{ route('users.admin_verify', $user->id) }}" method="POST" style="display:inline; margin-left: 8px;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Verify this account" style="padding:2px 8px; font-size:0.9em;">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                    </h4>
                    
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
                            <label for="name" class="form-label text-gold">Name</label>
                            <input type="text" class="form-control custom-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label text-gold">Email</label>
                            <input type="email" class="form-control custom-input" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        @can('manage_customer_credit')
                        <div class="form-group mb-3">
                            <label for="credit" class="form-label text-gold">Credit Management</label>
                            <div class="input-group">
                                <span class="input-group-text custom-input-group">$</span>
                                <input type="number" class="form-control custom-input" id="credit" name="credit" min="0" step="0.01" value="{{ old('credit', $user->credit) }}" required>
                            </div>
                            <div class="mt-2">
                                <small class="text-gold">Current credit balance: ${{ number_format($user->credit, 2) }}</small>
                            </div>
                        </div>
                        @else
                        <div class="form-group mb-3">
                            <label class="form-label text-gold">Credit Balance</label>
                            <div class="input-group">
                                <span class="input-group-text custom-input-group">$</span>
                                <input type="text" class="form-control custom-input" value="{{ number_format($user->credit, 2) }}" readonly>
                            </div>
                        </div>
                        @endcan

                        <div class="form-group mb-3">
                            <label for="role" class="form-label text-gold">Role</label>
                            <select name="role" id="role" class="form-control custom-input" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        data-permissions="{{ implode(',', $role->permissions->pluck('name')->toArray()) }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(Auth::user()->hasPermissionTo('admin_users'))
                        <div class="form-group mb-4">
                            <label class="form-label text-gold d-block">Permissions</label>
                            <div id="permissions-list">
                                @foreach($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input custom-checkbox permission-checkbox"
                                               type="checkbox" name="permissions[]"
                                               value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                                               data-permission="{{ $permission->name }}"
                                               {{ $permission->taken ? 'checked' : '' }}>
                                        <label class="form-check-label text-gold" for="permission_{{ $permission->id }}">
                                            {{ $permission->display_name ?? $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            @if(auth()->user()->hasPermissionTo('show_users'))
                                <a href="{{ route('users') }}" class="btn btn-gold">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-gold">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            @endif
                            <button type="submit" class="btn btn-gold">
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
    body, .main-bg, .container {
        background-color: #2c1e1e !important;
        color: #D4AF37;
    }
    .container {
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .edit-card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        border-radius: 10px;
        box-shadow: none;
    }
    .custom-input {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37 !important;
        color: #D4AF37 !important;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        background-color: #2c1e1e !important;
        border-color: #D4AF37 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15) !important;
        color: #D4AF37 !important;
    }
    .custom-input-group {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37 !important;
        color: #D4AF37 !important;
        border-radius: 8px 0 0 8px;
    }
    .custom-checkbox {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37 !important;
    }
    .custom-checkbox:checked {
        background-color: #D4AF37 !important;
        border-color: #D4AF37 !important;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .text-gold {
        color: #D4AF37 !important;
    }
    .btn-gold {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        padding: 8px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn-gold:hover {
        background-color: #2c1e1e !important;
        color: #D4AF37 !important;
        border: 1px solid #D4AF37 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }
    .alert-danger {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37 !important;
        color: #D4AF37 !important;
    }
    .form-check-inline {
        margin-right: 1rem;
    }
    .form-check-label {
        margin-left: 0.5rem;
    }
    .text-light, .text-muted, .text-primary, .text-secondary, .text-success, .text-info, .text-warning, .text-danger {
        color: #D4AF37 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updatePermissionsForRole() {
        var roleSelect = document.getElementById('role');
        var selectedOption = roleSelect.options[roleSelect.selectedIndex];
        var rolePermissions = selectedOption.getAttribute('data-permissions').split(',');

        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            if (rolePermissions.includes(checkbox.getAttribute('data-permission'))) {
                checkbox.checked = true;
                checkbox.disabled = true;
            } else {
                checkbox.disabled = false;
                // Only uncheck if not user-checked
                if (!checkbox.hasAttribute('data-user-checked')) {
                    checkbox.checked = false;
                }
            }
        });
    }

    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (!checkbox.disabled) {
                if (checkbox.checked) {
                    checkbox.setAttribute('data-user-checked', '1');
                } else {
                    checkbox.removeAttribute('data-user-checked');
                }
            }
        });
    });

    document.getElementById('role').addEventListener('change', updatePermissionsForRole);
    updatePermissionsForRole();
});
</script>
@endsection

</body>
</html>















