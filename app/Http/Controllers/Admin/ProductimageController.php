<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductimageController extends Controller
{
     //for the image 
     public function addimage($id)
     {
         $products = Product::findOrFail($id); // Fetch all products
    
         
         return view('admin.Products.image', compact('products'));
     }
 
     public function storeImage(Request $request)
     {

        $customMessages = [
            'image.required' => ' required.',
            'image.image' => ' must be a jpeg, png, or jpg image.',
            'image.mimes' => ' must be a jpeg, png, or jpg image.',
            'image.max' => ' not exceed 20MB.',
        ];
    
         $request->validate([
             'product_id' => 'required|exists:products,id',
             'image.*' => 'required|image|mimes:jpeg,png,jpg|max:20024',
         ],$customMessages);
     
         // Check if images are uploaded
         if ($request->hasFile('image')) {
             $isFirstImage = true;  // Flag to identify the first image
     
             foreach ($request->file('image') as $index => $imageFile) {
                 $fileName = time() . '_' . $index . '.' . $imageFile->getClientOriginalExtension();
                 $imageFile->move(public_path('uploads/productsimage'), $fileName);
     
                 // Always make the first image the master image
                 $isMaster = $isFirstImage;
                 if ($isMaster) {
                     Image::where('product_id', $request->product_id)->update(['is_master' => false]); // Unset previous master images
                 }
     
                 // Save the uploaded image
                 Image::create([
                     'product_id' => $request->product_id,
                     'image_path' => $fileName,
                     'is_master' => $isMaster,
                 ]);
     
                 // Set the flag to false after the first image
                 $isFirstImage = false;
             }
     
             return redirect()->back()->with('success', 'Images uploaded successfully!');
         }
     
         return redirect()->back()->with('error', 'No images were uploaded.');
     }
     
     
     
     // view related image

     public function relatedimage($id) {

        
        $product = Product::with('images')->findOrFail($id);
     
         // Make sure this is the correct property name
        
        
         return view('admin.Products.realtedimage')->with('product', $product);
    }

//delete the specific image

    public function deleteImage($id)
{
    
    // Find the product and the image
    
    $image = Image::findOrFail($id);

    
    // Delete the image file from the server
    $imagePath = public_path('uploads/productsimage/' . $image->image_path);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the image record from the database
    $image->delete();
    session()->flash('success', 'product image  has been successfully deleted.');

    return redirect()->back();
                     
}
public function setMasterImage($productId, $imageId)
{
    // Find the product
    $product = Product::findOrFail($productId);
    
    // Unset previous master images in the images table
    Image::where('product_id', $productId)->update(['is_master' => false]);
    
    // Set the selected image as master
    $image = Image::findOrFail($imageId);
    $image->is_master = true;
    $image->save();

    session()->flash('success', 'master has been successfully updated.');
    
    return redirect()->back();
}


    
}
