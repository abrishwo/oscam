@extends('admin.layout')

@section('content')
    <h1>Create Product</h1>
    <form id="create-product-form">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" required>
        </div>
        <div class="mb-3">
            <label for="batch_number" class="form-label">Batch Number</label>
            <input type="text" class="form-control" id="batch_number" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <script>
        document.getElementById('create-product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const token = localStorage.getItem('auth_token');
            const productName = document.getElementById('product_name').value;
            const batchNumber = document.getElementById('batch_number').value;

            fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_name: productName,
                    batch_number: batchNumber,
                }),
            }).then(() => {
                window.location.href = '{{ route("admin.products.index") }}';
            });
        });
    </script>
@endsection
