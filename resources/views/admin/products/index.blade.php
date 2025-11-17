@extends('admin.layout')

@section('content')
    <h1>Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Create Product</a>
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
        <tbody id="products-table">
            <!-- Products will be loaded here via JavaScript -->
        </tbody>
    </table>

    <script>
        const token = localStorage.getItem('auth_token');
        fetch('/api/products', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('products-table');
            data.data.forEach(product => {
                const row = `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.product_name}</td>
                        <td>${product.batch_number}</td>
                        <td>${product.status}</td>
                        <td>
                            <a href="/admin/products/${product.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                        </td>
                    </tr>
                `;
                table.innerHTML += row;
            });
        });

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                }).then(() => {
                    window.location.reload();
                });
            }
        }
    </script>
@endsection
