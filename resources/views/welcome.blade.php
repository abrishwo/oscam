<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container text-center mt-5">
            <h1>Product Verification API</h1>
            <p>Welcome to the Product Verification API. Please visit the admin panel to manage products.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Admin Panel</a>
        </div>
    </body>
</html>
