<footer>
  <div class="footer-top row">
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-question"></i>
      </div>
      <a href= "#" class="link">Visit our Support Center</a>
    </div>
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-box"></i>
      </div>
      <a href="{{ route('myaccount', ['tab'=> 'my-orders']) }}" class="link">Check your Orders</a>
    </div>
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-right-left"></i>
      </div>
      <a href="#" class="link">Returns & Exchanges Policy</a>
    </div>
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-dollar-sign"></i></div>
        <a href="{{ route('store') }}" class="link">Our Store</a>
    </div>
  </div>
  <!-- End Footer Top -->
  <hr>

  <div class="footer-bottom row">
    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>My Account</h4>
      <ul>
        @auth
        <li><a href="{{ route('myaccount') }}">My Account Page</a></li>
        <li><a href="{{ route('myaccount', ['tab'=> 'my-orders']) }}">My Orders</a></li>
        <li><a href="{{ route('logout') }}">Log Out</a></li>
        @endauth
        @guest
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('Signup') }}">Sign Up</a></li>
        @endguest
      </ul>
    </div>
    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>Categories</h4>
      <ul>
        <li><a href="{{ route('Store.AllCategories') }}">Show All Categoryies</a></li>
      </ul>
    </div>

    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>About Shop&Buy</h4>
      <ul>
        <li><a href="{{ route('Store.AllCategories') }}">Store</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Policy & Privacy</a></li>
      </ul>
    </div>

    <div class="footer-column col-sm-12 col-md-6 col-lg-3  footer-Email">
      <span class="footer-sgin-in">
        @auth
        <a href="{{ route('myaccount') }}">My Account</a>
        @endauth
        @guest
        <a href="{{ route('Signup') }}">Log in or Create Account</a>

        @endguest
      </span>

      <hr>
      <div class="social-icon">
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-youtube"></i></a>
        </div>
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-instagram"></i></a>
        </div>
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-tiktok"></i></a>
        </div>
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-facebook"></i></a>
        </div>
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-pinterest"></i></a>
        </div>
        <div class="iicon">
          <a href="#" class=""><i class="fa-brands fa-twitter"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>


  <!-- Bootstrap JS -->
<script>
    const searchUrl = "{{ route('products.search') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('product-search');
        const resultsBox = document.getElementById('search-results');

        input.addEventListener('keyup', function () {
            const query = this.value;

            if (query.length < 2) {
                resultsBox.innerHTML = '';
                return;
            }

            fetch(`${searchUrl}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                resultsBox.innerHTML = '';
                console.log(data);

                if (data.length === 0) {
                    resultsBox.innerHTML = '<div class="list-group-item text-muted">No results found.</div>';
                    return;
                }

                data.forEach(item => {
                    const div = document.createElement('a');
                    div.href = item.URL;
                    div.className = 'list-group-item list-group-item-action d-flex align-items-center';

                    div.innerHTML = `
                        <img src="${item.image}" alt="${item.title}" width="40" height="40" class="me-2 rounded">
                        <span>${item.title}</span>
                    `;

                    resultsBox.appendChild(div);
                });
            });
        });
    });
</script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="{{URL::asset('public/user/js/jquery-3.7.1.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (!isset($hideMessages))
  @include('user.messages.success')
  @include('user.messages.error')
  @endif
  <script src="{{URL::asset('public/user/js/main.js')}}"></script>
  @yield('js')
</body>
</html>
