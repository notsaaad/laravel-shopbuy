<aside class="Aside">
  <h2 class="logo">S&B</h2>
  <ul>
      <a href="{{ route('admin.home') }}" class="list-content list-link link">
        <div class="list-main-icon"><i class="fa-solid fa-gauge-high"></i></div>
        <div class="list-name">Dashbord</div>
      </a>

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
  </ul>
</aside>
