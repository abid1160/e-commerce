@extends('layouts.master')

@section('title', 'Employee List')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h3>Employee List</h3>
                <a href="{{ route('admin.employee.form') }}" class="btn btn-primary">Add New Employee</a>
            </div>
            <hr>
            <table id="employees" class="table table-striped table-bordered table-hover align-middle text-center shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Salary</th>
                        <th>Actions</th>
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
        $('#employees').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.employee.fetch') }}', // This is where the data will come from
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'city', name: 'city' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'role', name: 'role' },
                { data: 'salary', name: 'salary' },
                {
                    data: 'action', // The 'action' column will contain the edit and delete buttons
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data; // The edit and delete buttons are injected here
                    }
                }
            ]
        });

        // Initialize tooltips for dynamic content
        $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    });

    // Delete Employee Function
    function deleteEmployee(encryptedId) {
    if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
            url: "{{ route('admin.employee.delete', '__id__') }}".replace('__id__', encryptedId),
            type: "DELETE",
            data: {
                _token: '{{ csrf_token() }}' // Ensure CSRF token is available
            },
            success: function(response) {
                alert("Employee deleted successfully!");
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
