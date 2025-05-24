@extends('layouts.master')
@section('title', 'Default Permission Change')

@section('content')
<style>
    body {
        background-color:rgb(189, 147, 135);
        color:rgb(149, 110, 66);
    }

    .card-custom {
        background-color: #140a08;
        color: #f5f5f5;
        border-radius: 1rem;
        border: none;
    }

    .table-dark-brown {
        border-collapse: separate;
        border-spacing: 0;
        color:rgb(67, 42, 42);
    }

    .table-dark-brown thead th {
        background-color:rgb(60, 39, 31); /* dark rich brown for header cells */
        color: #d4af37;
        border: 1px solid #4a322f;
    }

    .table-dark-brown tbody td {
        background-color:rgb(67, 41, 31); /* ultra dark brown for body cells */
        border: 1px solid #3a2622; /* subtle border */
    }

    .form-check-input:checked {
        background-color: #a87e52;
        border-color: #a87e52;
    }

    .form-check-input {
        background-color: #2c1b17;
        border-color: #3a2622;
    }

    .btn-gold {
        background-color:rgb(70, 56, 11);
        color: #1a0f0c;
        border: none;
        font-weight: bold;
    }

    .btn-gold:hover {
        background-color: #bfa131;
    }
</style>


<div class="container py-5">
    <div class="card card-custom shadow-lg">
        <div class="card-body">
            <h2 class="mb-4 text-center text-warning">Manage Default Role Permissions</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('Defultpermissionchange.update') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-dark-brown">
                        <thead>
                            <tr>
                                <th>Role</th>
                                @foreach($permissions as $permission)
                                    <th>{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td class="fw-semibold text-warning">{{ ucfirst($role->name) }}</td>
                                    @foreach($permissions as $permission)
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="permissions[{{ $role->id }}][]"
                                                    value="{{ $permission->id }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-gold px-4 py-2 rounded-pill shadow">
                        Update Permissions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
