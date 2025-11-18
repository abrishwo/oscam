@extends('admin.layout')

@section('content')
    <h1>Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create Product</a>
    <a href="{{ route('admin.products.import') }}" class="btn btn-secondary">Import Products</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Batch Number</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->batch_number }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
