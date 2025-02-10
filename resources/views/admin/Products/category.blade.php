@extends('layouts.master')

@section('title','category List')

@section('content')  
<div class="container mt-5"> 
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-1">  
                <h3>Add category</h3>
                <a href="{{route('admin.product.add.category')}}" class="btn btn-primary">Add New Category</a>
            </div>
            <hr>
            <table id="category" class="table table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
   $(document).ready(function() {
        $('#category').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.product.category.fetch') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
               
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data 
                                ? `<a href="/uploads/categoryimage/${data}" target="_blank"><img src="/uploads/categoryimage/${data}" width="50" height="50" alt="Product Image"/></a>`  
                                : 'No Image';

                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data;
 
                    }
                }
            ]
        });

        // Initialize tooltips for dynamic content
        $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    });

    // Delete Product Function
    function deleteProductCategory(encryptedId) {
        if (confirm("Are you sure you want to delete this Product?")) {
        $.ajax({
            url: "{{ route('admin.product.category.delete', '__id__') }}".replace('__id__', encryptedId),
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

    // Edit Product Function
    function editProduct(id) {
        window.location.href = '{{ route('admin.product.category.edit', ':id') }}'.replace(':id', id);
    }

    // Add Image Function
  
</script>
@endpush
