@extends('layouts.master')

@section('title', 'Order List')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Orders List</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="ordersTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Total Price</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Products</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Add CSRF Token Meta Tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable
    $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.order.data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user.name', name: 'user.name', defaultContent: 'Guest' },
            { data: 'shipping_address', name: 'shipping_address', defaultContent: 'No Address' },
            { data: 'total_price', name: 'total_price' },
            { data: 'payment_status', name: 'payment_status' },
            { 
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    return `
                        <select class="form-select form-select-sm status-select" data-id="${row.id}">
                            <option value="pending" ${row.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="completed" ${row.status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="canceled" ${row.status === 'canceled' ? 'selected' : ''}>Canceled</option>
                        </select>
                    `;
                }
            },
            { 
                data: 'order_items', 
                name: 'order_items',
                orderable: false,
                searchable: false,
                render: function(data) {
                    let productList = '';
                    data.forEach(item => {
                        let imageUrl = item.product && item.product.images.length > 0 
                            ? `/uploads/productsimage/${item.product.images[0].image_path}` 
                            : 'https://via.placeholder.com/50';
                        
                        // Generate the URL dynamically using Blade route with placeholder
                        let productLink = "{{ route('admin.order.detail', ':id') }}";
                        productLink = productLink.replace(':id', item.product.id);  // Replace the placeholder with the actual product id

                        productList += `
                            <div class="d-flex align-items-center mb-2">
                               
                                <a href="${productLink}" class="text-primary fw-bold" target="_blank">
                                    ${item.product ? item.product.product_name : 'No Product'}
                                </a>
                                <span class="ms-2">x ${item.quantity}</span>
                            </div>
                        `;
                    });
                    return productList || 'No products';
                }
            },
            {
                data: 'id',
                render: function(data) {
                    return `<button class="btn btn-danger btn-sm" onclick="deleteOrder(${data})">Delete</button>`;
                }
            }
        ]
    });

    // Update order status using AJAX
    $(document).on('change', '.status-select', function() {
        let orderId = $(this).data('id');
        let status = $(this).val();

        console.log("Updating order " + orderId + " to status: " + status);

        $.ajax({
            url: `/admin/orders/${orderId}/update-status`,
            type: 'POST',
            data: { status: status },
            success: function(response) {
                alert(response.message);
                $('#ordersTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error updating order status');
            }
        });
    });
});

// Function to delete an order
function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
        $.ajax({
            url: `/admin/orders/${orderId}/delete`,
            type: 'DELETE',
            success: function(response) {
                alert(response.message);
                $('#ordersTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Error deleting order');
            }
        });
    }
}
</script>
@endpush
