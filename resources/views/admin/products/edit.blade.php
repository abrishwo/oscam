@extends('admin.layout')

@section('content')
    <h1>Edit Product</h1>
    <form id="edit-product-form">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" required>
        </div>
        <div class="mb-3">
            <label for="batch_number" class="form-label">Batch Number</label>
            <input type="text" class="form-control" id="batch_number" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status">
                <option value="original">Original</option>
                <option value="fake">Fake</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script>
        const productId = {{ $id }};
        const token = localStorage.getItem('auth_token');

        fetch(`/api/products/${productId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('product_name').value = data.product_name;
            document.getElementById('batch_number').value = data.batch_number;
            document.getElementById('status').value = data.status;
        });

        document.getElementById('edit-product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const productName = document.getElementById('product_name').value;
            const batchNumber = document.getElementById('batch_number').value;
            const status = document.getElementById('status').value;

            fetch(`/api/products/${productId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_name: productName,
                    batch_number: batchNumber,
                    status: status,
                }),
            }).then(() => {
                window.location.href = '{{ route("admin.products.index") }}';
            });
        });
    </script>
@endsection
