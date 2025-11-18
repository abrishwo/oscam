@extends('admin.layout')

@section('content')
    <h1>Scan Logs</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Device ID</th>
                <th>Geo Location</th>
                <th>User Agent</th>
                <th>Scanned At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scans as $scan)
                <tr>
                    <td>{{ $scan->id }}</td>
                    <td>{{ $scan->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $scan->device_id }}</td>
                    <td>{{ json_encode($scan->geo_location) }}</td>
                    <td>{{ $scan->user_agent }}</td>
                    <td>{{ $scan->scanned_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
