@extends('layouts.master')

@section('title', ' All Usersss List')

@section('content')
 
<div class="container mt-4">
    <!-- Check for success session flash message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>User List</h3>
        <a href="{{ route('admin.user.form.submit') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New User
        </a>
    </div>

    <div class="table-responsive">
        <table id="users" class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection   

@push('scripts')
<script type="text/javascript">
   $(document).ready(function() {
        $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.user.fetch') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'email', name: 'email' },
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

        // Initialize tooltips for dynamic content
        $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    });

    // Delete User Function
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '{{ route('admin.user.delete', '__id__') }}'.replace('__id__', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#users').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the user.');
                }
            });
        }
    }

    // Edit User Function
    // function editUser(id) {
    //     window.location.href = '{{ route('admin.user.edit', ':id') }}'.replace(':id', id);
    // }
</script>
@endpush
