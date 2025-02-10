@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Create Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                        </div>
                           <!-- Category Selection -->
                           <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="" disabled selected>Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sub-Category Selection -->
                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Sub-Category</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select" required>
                                <option value="" disabled selected>Select a Sub-Category</option>
                            </select>
                        </div>


                        <!-- Product Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea name="description[]" id="description" class="form-control" placeholder="Enter product description" required></textarea>
                        </div>

                        <!-- Color Options -->
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" name="color[]" id="color" class="form-control" placeholder="Enter color options" required>
                            <small class="text-muted">Enter multiple colors separated by commas</small>
                        </div>

                        <!-- Size Options -->
                        <div class="mb-3">
                            <label for="size" class="form-label">Size</label>
                            <input type="text" name="size[]" id="size" class="form-control" placeholder="Enter size options" required>
                            <small class="text-muted">Enter multiple sizes separated by commas</small>
                        </div>

                     
                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter product quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder="Enter product price" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
$(document).on('change', '#category_id', function() {
    const categoryId = $(this).val(); // Get the selected category ID
    const subcategorySelect = $('#subcategory_id');

    // Clear existing subcategories
    subcategorySelect.html('<option value="" disabled selected>Loading...</option>');

    // Fetch subcategories via AJAX
    $.ajax({
        url: `{{ route('admin.getSubcategories', '') }}/${categoryId}`, // Correct way to insert the categoryId dynamically
        method: 'GET',
        success: function(data) {
            // Assuming 'data' is an array of subcategories
            let options = '<option value="" disabled selected>Select a Sub-Category</option>';
            data.forEach(function(subcategory) {
                options += `<option value="${subcategory.id}">${subcategory.name}</option>`;
            });
            subcategorySelect.html(options); // Update the subcategory dropdown with the new options
        },
        error: function() {
            subcategorySelect.html('<option value="" disabled selected>Failed to load subcategories</option>');
        }
    });
});
</script>
@endpush
@endsection
