@extends('home.layouts.master')

@section('title', 'Cart List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Your Shopping Cart</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-warning" role="alert">
            Your cart is empty. Add some items to your cart!
        </div>
    @else
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>    
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                       <td><img src="{{ asset('uploads/productsimage/' . $item->image) }}" alt="{{ $item->product_name }}" class="img-fluid" style="max-width: 80px;"></td>
                       <td>{{ $item->product->product_name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            <input type="number" class="form-control update-quantity" 
                                   data-id="{{ $item->product_id }}" 
                                   value="{{ $item->quantity }}" 
                                   min="1" style="width: 70px;">
                        </td>
                        <td class="product-total">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm remove-from-cart" onclick="onDelete({{$item->product->id}});">Remove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>   
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                    <td colspan="2" id="cart-total">
                        ${{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between">
            {{-- <h4>Total: $<span id="cart-total">{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</span></h4> --}}
            <a href="{{route('user.checkout')}}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).on('change', '.update-quantity', function () {
    let productId = $(this).data('id'); // Get product ID from data attribute
    let quantity = $(this).val(); // New quantity value
    let row = $(this).closest('tr'); // Select the row to update total dynamically

    $.ajax({
        url: "{{ route('user.update.cart') }}", // Ensure this route matches your Laravel route
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: productId,
            quantity: quantity
        },
        success: function (response) {
            if (response.status) {
                // Update the total price for the product
                let productPrice = parseFloat(row.find('td:nth-child(3)').text().replace('$', ''));
                let productTotal = (productPrice * quantity).toFixed(2);
                row.find('.product-total').text('$' + productTotal);

                // Update the cart total
                updateCartTotal();
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert('Something went wrong. Please try again.');
        }
    });
});

function updateCartTotal() {
    let total = 0;
    $('table tbody tr').each(function () {
        let productTotal = parseFloat($(this).find('.product-total').text().replace('$', '')) || 0;
        total += productTotal;
    });
    $('#cart-total').text('$' + total.toFixed(2)); // Update the overall cart total
}

function onDelete(id){
    $.ajax({
        url: "{{ route('user.remove.cart') }}",
        type: 'post',
        data: {
            id: id,    
            _token: '{{ csrf_token() }}' // Include the CSRF token here
        },
        success: function(response) {

            if(response.status==true){
                window.location.href="{{route('user.cart')}}";

            }else{
                alert(response.message);
            }
            
        }
        
    });
}

</script>
@endpush
