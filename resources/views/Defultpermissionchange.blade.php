@extends('layouts.master')
@section('title', 'Default Permission Change')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Default Permissions for Roles</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('Defultpermissionchange.update') }}">
        @csrf
        <table class="table table-bordered table-striped">
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
                        <td>{{ $role->name }}</td>
                        @foreach($permissions as $permission)
                            <td>
                                <input type="checkbox" name="permissions[{{ $role->id }}][]" value="{{ $permission->id }}" 
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update Default Permissions</button>
    </form>
</div>
@endsection
