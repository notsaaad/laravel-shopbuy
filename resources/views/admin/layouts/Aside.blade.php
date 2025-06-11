<aside class="Aside">
  <h2 class="logo">S&B</h2>
  <ul>
      <a href="{{ route('admin.home') }}" class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-gauge-high"></i></div>
        <div class="list-name">Dashbord</div>
      </a>
    {{--==================== start Products =============================  --}}
    <li class="DropDown ">
      <div class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        <div class="list-name">Product</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('admin.product.add') }}" class="list-link link">Add</a>
        <a href="{{ route('admin.products.index') }}" class="list-link link">View</a>
      </ul>
    </li>
    {{--==================== End Products =============================  --}}

    {{--==================== start category =============================  --}}
    <li class="DropDown ">
      <div class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        <div class="list-name">Category</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('category.create') }}" class="list-link link">Add</a>
        <a href="{{ route('category.index') }}" class="list-link link">View</a>
      </ul>
    </li>
    {{--==================== End category =============================  --}}

        {{--==================== start Attributes =============================  --}}
        <li class="DropDown ">
          <div class="list-content list-link link">
            <div class="list-main-icon"><i class="fa-solid fa-box-archive"></i></div>
            <div class="list-name">Attribute</div>
            <i class="dropDown-icon fa-solid fa-sort-down"></i>
          </div>
          <ul class="submenu">
            <a href="{{ route('attribute.add') }}" class="list-link link">Add</a>
            <a href="{{ route('attribute.index') }}" class="list-link link">View</a>
          </ul>
        </li>
        {{--==================== End Attributes =============================  --}}

        {{--==================== start Users =============================  --}}
    <li class="DropDown ">
      <div class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-users"></i></div>
        <div class="list-name">User</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('users.create') }}" class="list-link link">Add</a>
        <a href="{{ route('users.index') }}" class="list-link link">View</a>
      </ul>
    </li>


            {{--==================== End Users =============================  --}}
        {{--==================== start Users =============================  --}}
    <li class="DropDown ">
      <div class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-boxes-packing"></i></div>
        <div class="list-name">Order</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('admin.order.add') }}" class="list-link link">Add</a>
        <a href="{{ route('admin_order_view') }}" class="list-link link">View</a>
      </ul>
    </li>


            {{--==================== End Users =============================  --}}
  </ul>
</aside>
