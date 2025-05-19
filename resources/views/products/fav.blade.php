@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🌟 Favourite Products</h2>

    @if($products->isEmpty())
        <div class="alert alert-info">No favourite products yet.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Marked As Favourite</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td><span class="badge bg-success">Yes</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
