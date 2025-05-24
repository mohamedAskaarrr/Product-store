@extends('layouts.master') {{-- Adjust this to your master/admin layout --}}

@section('title', 'Create New Role')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-18">

            <div class="card shadow-sm rounded">
                <div class="card-header text-white">
                    <h3 >Create New Role</h3>
                </div>

                <div class="card-body">
                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Role Creation Form --}}
                    <form action="{{ route('AddRole') }}" method="POST" novalidate>
                        @csrf

                        {{-- Role Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                                placeholder="Enter role name e.g., Admin, Employee">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Permissions (Optional) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Assign Permissions (Optional)</label>

                            @if($permissions->isEmpty())
                                <p class="text-muted fst-italic small">
                                    No permissions available. Consider creating permissions first (via seeders or admin panel).
                                </p>
                            @else
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="permissions[]" 
                                                    id="permission_{{ $permission->id }}" 
                                                    value="{{ $permission->id }}" 
                                                    {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @error('permissions')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('permissions.*')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2">
                            {{-- Uncomment if you want cancel button --}}
                            {{-- <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a> --}}
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .form-check-label {
        color: #d4af37; /* White permission labels */
    }
    .card, 
.card * {
    color:rgb(230, 223, 200); /* White text everywhere inside the card */
}

input.form-control, 
input.form-control::placeholder {
    color:rgb(160, 148, 122) !important; /* Input text & placeholder white */
    background-color: #2a1b18; /* Optional: dark background for inputs */
    border-color: #4a322f; /* Optional: input border color */
}

.alert {
    color: #d4af37; /* Alert text white */
}


</style>

@endsection
