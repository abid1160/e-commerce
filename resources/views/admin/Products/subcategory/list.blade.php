@extends('layouts.master')

@section('title','subcategory List')

@section('content')  
<div class="container mt-5"> 
    <div class="row">
        <div class="col-md-12">  
            <div class="d-flex justify-content-between mb-1">  
                <h3>Add Subcategory</h3>
                <a href="{{route('admin.product.add.subcategory')}}" class="btn btn-primary">Add New  Subcategory</a>
            </div>
            <hr>
            <table id="subcategory" class="table table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th> Name</th>
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
        $('#subcategory').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('admin.product.subcategory.fetch')}}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'category.name', name: 'category.name' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
               
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data 
                                ? `<a href="/uploads/subcategoryimage/${data}" target="_blank"><img src="/uploads/subcategoryimage/${data}" width="50" height="50" alt="Subcategory Image"/></a>`  
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
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '{{ route('admin.product.subcategory.delete', ':id') }}'.replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#subcategory').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the product.');
                }
            });
        }
    }

    // Edit Product Function
    

    // Add Image Function
  
</script>
@endpush
