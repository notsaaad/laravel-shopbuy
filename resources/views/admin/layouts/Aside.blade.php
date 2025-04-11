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
        <div class="list-name">Products</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('admin.product.add') }}" class="list-link link">Add</a>
        <a href="#" class="list-link link">View</a>
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

        {{--==================== start Users =============================  --}}
    <li class="DropDown ">
      <div class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-users"></i></div>
        <div class="list-name">Users</div>
        <i class="dropDown-icon fa-solid fa-sort-down"></i>
      </div>
      <ul class="submenu">
        <a href="{{ route('users.create') }}" class="list-link link">Add</a>
        <a href="{{ route('users.index') }}" class="list-link link">View</a>
      </ul>
    </li>


            {{--==================== End Users =============================  --}}
  </ul>
</aside>
