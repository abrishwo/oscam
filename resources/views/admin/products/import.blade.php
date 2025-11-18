@extends('admin.layout')

@section('content')
    <h1>Import Products</h1>
    <form action="{{ route('admin.products.import.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">CSV/Excel File</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
@endsection
