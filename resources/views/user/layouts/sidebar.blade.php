<div class="sidebar" id="sidebar">
  <div class="menu-section">
    <h4>Shop by Department</h4>
    @if (! Auth::check())
    <a class="menu-item" href="{{route('Signup')}}">My Account</a>
    @endif
    <div class="DropDown">
      <a class="menu-item">Appliances</a>
      <div class="submenu">
        <a class="menu-item" href="#">Link 1</a>
        <a class="menu-item" href="#">Link 2</a>
        <a class="menu-item" href="#">Link 3</a>
      </div>
    </div>

    <a href="#" class="menu-item">TV & Home Theater</a>
    <a href="#" class="menu-item">Computers & Tablets</a>
    <a href="#" class="menu-item">Cell Phones</a>
    <a href="#" class="menu-item">Audio</a>
    <a href="#" class="menu-item">Video Games</a>
  </div>
  <div class="menu-section">
    <h4>Deals</h4>
    <a href="#" class="menu-item">View All Deals</a>
  </div>
  <div class="menu-section">
    <h4>Support & Services</h4>
    <a href="#" class="menu-item">Customer Support</a>
    <a href="#" class="menu-item">Repair Services</a>
  </div>
  <div class="menu-section">
    <h4>Brands</h4>
    <a href="#" class="menu-item">Top Brands</a>
  </div>
</div>
