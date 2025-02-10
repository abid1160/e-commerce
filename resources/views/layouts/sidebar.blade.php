<div class="sidebar" data-color="light-green">
  <div class="logo">
    <div class="logo text-center py-3">
      <a href="{{ route('admin.dashboard') }}" class="text-dark font-weight-bold">
        <i class="fas fa-cogs"></i> Admin Panel
      </a>
    </div>
    
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
     

    <li>
      <a href="{{route('admin.dashboard')}}">
        <i class="now-ui-icons design_bullet-list-67"></i> <!-- Changed icon for Dashboard -->
        <p>Dashboard</p>
    </a>
    </li>
    
    <li>
        <a href="{{route('admin.user.profile')}}">
            <i class="now-ui-icons users_circle-08"></i> <!-- Changed icon for User list -->
            <p>User list</p>
        </a>
    </li>

     
  
  <li>
    <a href="{{route('admin.employee.profile')}}">
        <i class="now-ui-icons users_circle-08"></i> <!-- Changed icon for Product list -->
        <p>Employee list</p>
    </a>
</li>
 
<li>
  <a data-toggle="collapse" href="#manageProductMenu" aria-expanded="false">
    <i class="now-ui-icons shopping_box"></i>
    <p>Manage Product</p>
  </a>
  <div class="collapse" id="manageProductMenu">
    <ul class="nav pl-4">
      <li>
        <a href="{{route('admin.product.category.list')}}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>Category List</p>
        </a>
      </li>
      <li>
        <a href="{{route('admin.product.subcategory.list')}}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>Subcategory List</p>
        </a>
      </li>
      <li>
        <a href="{{route('admin.product.list')}}" id="load-product-list">
          <i class="now-ui-icons shopping_box"></i>
          <p>Product List</p>
        </a>
      </li>
    </ul>
  </div>


</li>   
      <li>
    <a href="{{route('admin.order.list')}}">
        <i class="now-ui-icons shopping_box"></i> <!-- Changed icon for Product list -->
        <p>manage Order</p>
    </a>
</li>
<li>
  <a href="{{route('admin.discount.list')}}">
      <i class="now-ui-icons shopping_box"></i> <!-- Changed icon for Product list -->
      <p>manage Discount</p>
  </a>
</li>
      
      
    </ul>
  </div>