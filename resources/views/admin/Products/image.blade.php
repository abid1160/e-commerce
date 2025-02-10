@extends('layouts.master')

@section('title', 'add Product Image')

@section('content')
<div class="container mt-5" style="max-width: 600px; margin: auto;">
    <div class="card shadow-sm border-light rounded">
        <div class="card-header bg-primary text-white text-center">
            <h1>add Product Image</h1>
        </div>

        <div class="card-body">
            <!-- Display Success Message if available -->
            @if(session('success'))
                <div style="color: green; padding-bottom: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Validation Errors for Image Upload -->
            @if ($errors->any())
                <div style="color: red; padding-bottom: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Upload Image Form -->
            <form action="{{ route('admin.product.image.insert') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Hidden Product ID -->
                <input type="hidden" name="product_id" value="{{ $products->id }}">

                <!-- Upload Image -->
                <div style="margin-bottom: 15px;">
                    
                    <label for="image" style="display: block; margin-bottom: 5px;">Upload Images:<span class="text-danger">*</span></label>
                    <input type="file" name="image[]" id="image" accept="image/*" multiple required style="padding: 10px; width: 100%; border-radius: 5px; border: 1px solid #ddd;" onchange="previewImages()">
                    
                    <!-- Display Custom Error Message for Image -->
                    @error('image')
                        <div style="color: red; padding-top: 5px;">
                            {{ $message }} <!-- Custom error message -->
                        </div>
                    @enderror
                </div>

                <!-- Image Previews Section -->
                <div id="imagePreviews" style="margin-bottom: 15px;">
                    <!-- Dynamically displayed images will appear here -->
                </div>

                <!-- Submit Button -->
                <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; width: 100%; cursor: pointer;">
                    Upload Image
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImages() {
        var previewContainer = document.getElementById('imagePreviews');
        previewContainer.innerHTML = ''; // Clear previous previews
        
        var files = document.getElementById('image').files;
        
        if (files.length == 0) {
            // If no images are selected, show the error message
            document.getElementById('image-error').style.display = 'block';
        } else {
            // If images are selected, hide the error message
            document.getElementById('image-error').style.display = 'none';
        }
        
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('img-thumbnail', 'm-2');
                imgElement.style.maxWidth = '100px';
                imgElement.style.maxHeight = '100px';
                imgElement.setAttribute('data-index', i); // Add an index for identification
                
                previewContainer.appendChild(imgElement);
            };
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
