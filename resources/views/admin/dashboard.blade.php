@extends('admin.layout')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome to the admin panel.</p>
    <ul>
        <li><a href="{{ route('admin.products.index') }}">Products</a></li>
    </ul>
@endsection
