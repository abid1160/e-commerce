<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductimageController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\home\CategoryController as HomeCategoryController;
use App\Http\Controllers\home\HomepageController;
use App\Http\Controllers\home\LoginController as HomeLoginController;
use App\Http\Controllers\home\men\MenController;
use App\Http\Controllers\home\RegisterController as HomeRegisterController;
use App\Http\Controllers\home\SubcategoryController as HomeSubcategoryController;
use App\Http\Controllers\home\user\HomeController;
use App\Http\Controllers\home\ProductCntroller as HomeProductController;
use App\Http\Controllers\home\user\CartController;
use App\Http\Controllers\home\user\OrderController;
use App\Http\Controllers\home\user\PaymentController;
// Corrected typo here


use App\Models\Category;
use App\Models\Subcategory;

// Guest routes (accessible only to non-authenticated users)'

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/admin', function () {
        return redirect()->route('login.form');
    });
    // Route for showing the login form (admin)
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');

    // Route for handling login submission (admin)
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');

    // Route for the forget password form
    Route::get('/forget-password', [ForgetPasswordController::class, 'showforgetpasswordform'])->name('forgetpassword');

    // Route for submitting the forget password form
    Route::post('/forget-password', [ForgetPasswordController::class, 'submitforgetpasswordform'])->name('forgetpassword.submit');

    // Route for the reset password form
    Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'showresetpasswordform'])->name('resetpassword.form');

    // Route for submitting the reset password form
    Route::post('/reset-password/submit', [ForgetPasswordController::class, 'submitresetpasswordform'])->name('resetpassword.submit');
});



// Authenticated routes (accessible only to authenticated users)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // Logout route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Admin dashboard route
    Route::get('dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // Admin profile routes
    Route::get('profile', [DashboardController::class, 'viewProfile'])->name('profile');
    Route::post('profile/update', [DashboardController::class, 'updateProfile'])->name('update');

    //admin change password
    Route::get('/change-password', [DashboardController::class, 'changepasswordform'])->name('change.password.form');
    Route::post('/change-password', [DashboardController::class, 'changepassword'])->name('change.password');

    //user profile route

    // User Profile route (handles user-related logic)
    Route::get('/user/list', [UserController::class, 'userList'])->name('user.profile');
    Route::get('/user/list/fetch', [UserController::class, 'data'])->name('user.fetch');







    Route::get('/add/user/form', [UserController::class, 'adduserform'])->name('user.form');
    Route::post('/add/user/form', [UserController::class, 'addusersubmit'])->name('user.form.submit');
    Route::delete('/admin/user/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');

    //search the user
    Route::get('/user/search', [UserController::class, 'usersearch'])->name('user.search');




    //route for the productvv

    // web.php (routes file)
    // web.php (routes file)
    Route::get('/product/list', [ProductController::class, 'index'])->name('product.list');
    Route::get('/product/fetch', [ProductController::class, 'data'])->name('product.fetch');
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('getSubcategories');


    Route::get('product/{id}', [ProductController::class, 'productDetail'])->name('product.detail');

    Route::get('/product/create/form', [ProductController::class, 'create'])->name('product.create.form');

    Route::post('/product/insert', [ProductController::class, 'productinsert'])->name('product.insert');
    Route::delete('/product/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');


   
    //route for the employee

    Route::get('/employee/list', [EmployeeController::class, 'index'])->name('employee.profile');
    Route::get('/employee/list/fetch', [EmployeeController::class, 'data'])->name('employee.fetch');
    Route::delete('/employee/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('/employee/form', [EmployeeController::class, 'addemployeeform'])->name('employee.form');
    Route::post('/employee/insert', [EmployeeController::class, 'employeeinsert'])->name('employee.insert');



    //route for the product image

    Route::get('add/product/image/{id}', [ProductimageController::class, 'addimage'])->name('product.image');

    Route::post('/add/product/image', [ProductimageController::class, 'storeImage'])->name('product.image.insert');


    Route::get('/product/all/image/{id}', [ProductimageController::class, 'relatedimage'])->name('product.related.image');



    //delete the specific image
    Route::delete('/product/{id}/image', [ProductimageController::class, 'deleteImage'])
        ->name('product.image.delete');
    Route::post('/product/{productId}/image/{imageId}/set-master', [ProductImageController::class, 'setMasterImage'])
        ->name('product.image.set_master');

    //route for the user ajax
    // Route::post('user/check-email', [UserController::class, 'checkUserExists'])->name('user.email');
    Route::post('/user/check', [UserController::class, 'checkUserExists'])->name('user.check');

    Route::post('employee/check', [EmployeeController::class, 'checkPhoneNumber'])->name('employee.check');


    //route related to category

    Route::get('/product/category/list', [CategoryController::class, 'index'])->name('product.category.list');
    Route::get('/product/category/list/fetch', [CategoryController::class, 'data'])->name('product.category.fetch');
    Route::get('/product/category/form', [CategoryController::class, 'add'])->name('product.add.category');
    Route::post('/product/category/insert', [CategoryController::class, 'insert'])->name('product.category.insert');
    Route::delete('/product/category/{id}', [CategoryController::class, 'delete'])->name('product.category.delete');
    Route::get('/product/category/edit/{id}', [CategoryController::class, 'edit'])->name('product.category.edit');
    
   Route::post('/product/category/update',[CategoryController::class,'update'])->name('product.category.update');

    //route related to subcategory
    Route::get('/product/subcategory/list', [SubcategoryController::class, 'index'])->name('product.subcategory.list');
    Route::get('/product/subcategory/list/fetch', [SubcategoryController::class, 'data'])->name('product.subcategory.fetch');
    Route::get('/product/subcategory/form', [SubcategoryController::class, 'add'])->name('product.add.subcategory');
    Route::post('/product/subcategory/insert', [SubcategoryController::class, 'insert'])->name('product.subcategory.insert');
    Route::delete('/product/subcategory/{id}', [SubcategoryController::class, 'delete'])->name('product.subcategory.delete');
    Route::get('/product/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('product.subcategory.edit');
    Route::post('/product/subcategory/update', [SubcategoryController::class, 'update'])->name('product.subcategory.update');

  

    //route for the order list
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('order.list');
Route::get('/orders/data', [AdminOrderController::class, 'data'])->name('order.data');
Route::delete('/orders/{id}/delete', [AdminOrderController::class, 'delete'])->name('order.delete');
Route::post('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('order.updateStatus');
//order detail
Route::get('product/{id}', [AdminOrderController::class, 'orderDetail'])->name('order.detail');
    

//code related to the discount
Route::get('/discount/list',[DiscountController::class,'index'])->name('discount.list');

Route::get('/discount/list/fetch', [DiscountController::class, 'data'])->name('discount.fetch');

Route::get('/discount/create',[DiscountController::class,'create'])->name('discount.create');

//store
Route::post('/discount/store',[DiscountController::class,'store'])->name('discount.store');

//delete
Route::delete('/discount/{id}', [DiscountController::class, 'delete'])->name('discount.delete');
Route::get('/discount/edit/{id}',[DiscountController::class,'edit'])->name('discount.edit');

Route::post('/discount/update', [DiscountController::class, 'update'])->name('discount.update');
});  




//all the route related to the home page
//all the common route for the guest and the user.......
Route::get('/', [HomepageController::class, 'home'])->name('website');
Route::get('products/{category}', [HomeSubcategoryController::class, 'list'])->name('subcategory');
Route::get('product/{category_id}/{subcategory_id}', [HomeProductController::class, 'product'])->name('product');















// Apply UserGuest middleware to the login routes
Route::middleware('userguest')->group(function () {
    // Login form for the user
    Route::get('/user/login/form', [HomeLoginController::class, 'loginform'])->name('user.login.form');
    Route::post('/user/login/form', [HomeLoginController::class, 'login'])->name('user.login.submit');

    // Registration form for the user
    Route::get('/user/registration/form', [HomeRegisterController::class, 'showRegistrationForm'])->name('user.register.form');

    // Registration form submit
    Route::post('/user/registration/form/submit', [HomeRegisterController::class, 'register'])->name('user.register.form.submit');
});


Route::middleware('auth:user')->prefix('user')->name('user.')->group(function () {
    // User homepage route

    Route::get('/payment/done',function(){
        return view('home.user.success');
    })->name('payment.done');
    
    // Profile route
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');

    // Logout route
    Route::post('logout', [HomeLoginController::class, 'logout'])->name('logout');


    //view cart
    Route::get('cart', [CartController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{product_id}', [CartController::class, 'addToCart'])->name('add.cart');

    Route::post('/cart/remove/', [CartController::class, 'removeFromCart'])->name('remove.cart');
    Route::post('/user/cart/update', [CartController::class, 'updateCart'])->name('update.cart');

    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('new/address', [OrderController::class, 'addressmodal'])->name('addressmodal');
    Route::post('/orderdetail/{userId}/{addressId}', [OrderController::class, 'orderDetail'])->name('orderdetail');


    //route for the payment
    Route::post('/payment/done', [PaymentController::class, 'index'])->name('payment');
    // routes/web.php
    Route::post('/charge', [PaymentController::class, 'charge'])->name('charge');
   
   
    //route for the view order
    Route::get('/order/view',[OrderController::class,'viewOrders'])->name('view.order');
   Route::delete('/order/delete/{id}',[OrderController::class,'delete'])->name('order.delete');

   
    
});


//for the practise only
Route::get('/self',function(){

    return view('self');
});