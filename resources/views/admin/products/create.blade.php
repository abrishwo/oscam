@extends('admin.layout')

@section('content')
    <h1>Create Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="batch_number">Batch Number</label>
            <input type="text" name="batch_number" id="batch_number" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="original">Original</option>
                <option value="fake">Fake</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
