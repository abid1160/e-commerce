@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Manage Discount Codes</h2>
        <a href="{{ route('admin.discount.create') }}" class="btn btn-primary mb-3">Add Discount</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table id="discounts" class="table table-striped table-bordered table-hover align-middle text-center shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Valid From</th>
                    <th>Valid To</th>      
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection     

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#discounts').DataTable({
                processing: true,
                serverSide: true,  
                ajax: '{{ route('admin.discount.fetch') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user' },
                    {
                        data: 'product',
                        name: 'product',
                        render: function(data, type, row) {
                            if (!data || data === "No Product Assigned") {
                                return `<span class="text-muted">No Product Assigned</span>`;
                            }
                            const url = '{{ route('admin.order.detail', ':id') }}'.replace(':id', row.product_id);
                            return `<a href="${url}" class="text-decoration-none">${data}</a>`;
                        }
                    }, // ✅ Fixed missing comma
                    { data: 'type', name: 'type' },
                    { data: 'value', name: 'value' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
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

            $('body').tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        });
      
    function deleteDiscount(id) {
 
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '{{ route('admin.discount.delete', '__id__') }}'.replace('__id__', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#discounts').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the user.');
                }
            });
        }
    }    
    </script>  
    
@endpush
