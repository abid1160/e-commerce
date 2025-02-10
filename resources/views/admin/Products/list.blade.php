@extends('layouts.master')

@section('title','Products List')

@section('content')
<div class="container mt-5"> 
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h3>Product List</h3>
                <a href="{{ route('admin.product.create.form') }}" class="btn btn-primary">Add New Product</a> 
            </div>
            <hr>
            <table id="products" class="table table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.product.fetch') }}', 
            columns: [
                { data: 'id', name: 'id' },
                { 
                    data: 'product_name', 
                    name: 'product_name',
                    render: function(data, type, row) {
                        const url = '{{ route('admin.order.detail', ':id') }}'.replace(':id', row.id); 
                        return `<a href="${url}" class="text-decoration-none">${data}</a>`;
                    }
                },
                { data: 'price', name: 'price' },
                { data: 'quantity', name: 'quantity' },
                { data: 'category.name', name: 'category.name' },
                { data: 'subcategory.name', name: 'subcategory.name' },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        return data; // Action buttons will be injected here
                    }
                }
            ]
        });

        // Initialize tooltips for Bootstrap 5
        $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    });

    // Delete Product Function
    function deleteProduct(encryptedId) {
        if (confirm("Are you sure you want to delete this Product?")) {
        $.ajax({
            url: "{{ route('admin.product.delete', '__id__') }}".replace('__id__', encryptedId),
            type: "DELETE",
            data: {
                _token: '{{ csrf_token() }}' // Ensure CSRF token is available
            },
            success: function(response) {
                alert("Product deleted successfully!");   
                location.reload();
            },
            error: function(xhr) {
                alert("An error occurred while deleting the employee.");
            }
        });
    }
    }
</script>
@endpush