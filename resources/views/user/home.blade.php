<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Entertainment</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/all.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/fontawesome.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/master.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/home.css')}}">

</head>
<body>

      <!-- ================================================== Start Header ==================================================== -->
      <div class="aside-overlay">
        <button class="close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <header class="header">
          <div class="main-header-content">
            <div class="logo"><b>S&B</b></div>
            <button class="menu-button" id="menuButton">
                <span class="menu-icon"></span> Menu
            </button>

            <div class="search-bar-container">
                <input type="text" placeholder="What can we help you find today?" class="search-bar">
                <button class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <div class="header-icons">
                <div class="cart">
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
          </div>
          <div class="navbar">
            <a class="links" href="#">Top Deals</a>
            <a class="links" href="#">Deal of the Day</a>
            <a class="links" href="#">Yes, Best Buy Sells That</a>
            <a class="links" href="#">My Best Buy Memberships</a>


            <div class="dropdown">
              <a class="links" href="">MORE &#9662;</a>
              <div class="dropdown-content">
                  <a href="#"> option 1</a>
                  <a href="#"> option 1</a>
                  <a href="#">option  3</a>
              </div>
          </div>

          <div class="dropdown">
            <a class="links" href="">account &#9662;</a>
            <div class="dropdown-content">
              <a href="#">option 1</a>
              <a href="#">option 2</a>
              <a href="#">option 3</a>
            </div>
        </div>

        <div class="dropdown">
          <a class="links" href="">order status &#9662;</a>
          <div class="dropdown-content">
            <a href="#">option 1</a>
            <a href="#">option 2</a>
            <a href="#">option 3</a>
          </div>
      </div>

      <div class="dropdown">
        <a class="links" href="">saved items &#9662;</a>
        <div class="dropdown-content">
          <a href="#">option 1</a>
          <a href="#">option 2</a>
          <a href="#">option 3</a>
        </div>
    </div>





        </div>

      </header>
      <div class="sidebar" id="sidebar">
        <div class="menu-section">
          <h4>Shop by Department</h4>
          <div class="DropDown">
            <a class="menu-item" href="#">Appliances</a>
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
    <!-- ================================================== End Header ==================================================== -->


      <div class="main-content">
                <!-- Hero Section -->
        <div class="container-fluid hero-section">
          <div class="row w-100">
            <div class="col-md-6">
              <img src="{{asset('public/user/images/9.jpeg')}}"alt="TV image" class="img-fluid">
            </div>
            <div class="col-md-6 hero-text">
              <h1 class="fw-bold">The best home entertainment system is here</h1>
              <p class="text-muted">Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.</p>
              <a href="#" class="btn btn-primary">Shop now</a>
            </div>
          </div>
        </div>

        <!-- Features Section -->
        <div class="container features-section mt-5">
          <div class="row">
            <div class="col-md-3 feature-item">
              <i class="bi bi-truck"></i>
              <h6 class="mt-3">Free shipping</h6>
              <p class="text-muted">When you spend $80 or more</p>
            </div>
            <div class="col-md-3 feature-item">
              <i class="bi bi-headset"></i>
              <h6 class="mt-3">We are available 24/7</h6>
              <p class="text-muted">Need help? Contact us anytime</p>
            </div>
            <div class="col-md-3 feature-item">
              <i class="bi bi-arrow-return-left"></i>
              <h6 class="mt-3">Satisfied or return</h6>
              <p class="text-muted">Easy 30-day return policy</p>
            </div>
            <div class="col-md-3 feature-item">
              <i class="bi bi-lock"></i>
              <h6 class="mt-3">100% secure payments</h6>
              <p class="text-muted">Visa, Mastercard, Stripe, PayPal</p>
            </div>
          </div>
        </div>


      <!-- Section 2: Product Categories -->
      <div class="container mt-5">
          <h2 class="text-center mb-4">Product Categories</h2>
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Air Conditioner -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/10.jpeg')}}" alt="Air Conditioner" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">AIR CONDITIONER</h6>
                  <p class="card-text text-muted">4 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Audio & Video -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/11.jpeg')}}" alt="Audio & Video" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">AUDIO & VIDEO</h6>
                  <p class="card-text text-muted">5 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Gadgets -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/12.jpeg')}}" alt="Gadgets" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">GADGETS</h6>
                  <p class="card-text text-muted">6 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Home Appliances -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/13.jpeg')}}" alt="Home Appliances" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">HOME APPLIANCES</h6>
                  <p class="card-text text-muted">5 PRODUCTS</p>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div class="container mt-5">
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Air Conditioner -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/14.jpeg')}}" alt="Air Conditioner" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">AIR CONDITIONER</h6>
                  <p class="card-text text-muted">4 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Audio & Video -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/15.jpeg')}}" alt="Audio & Video" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">AUDIO & VIDEO</h6>
                  <p class="card-text text-muted">5 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Gadgets -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/16.jpeg')}}" alt="Gadgets" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">GADGETS</h6>
                  <p class="card-text text-muted">6 PRODUCTS</p>
                </div>
              </div>
            </div>
            <!-- Home Appliances -->
            <div class="col">
              <div class="card text-center border-0">
                <img src="{{asset('public/user/images/17.jpeg')}}" alt="Home Appliances" class="card-img-top mx-auto mt-3" style="width: 120px;">
                <div class="card-body">
                  <h6 class="card-title">HOME APPLIANCES</h6>
                  <p class="card-text text-muted">5 PRODUCTS</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Section 3: Today's Best Deal -->
        <div class="container mt-5">
          <h2 class="text-center mb-4">Today's Best Deal</h2>
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Product 1 -->
            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/17.jpeg')}}" class="card-img-top" alt="Product 1">
                <div class="card-body">
                  <h5 class="card-title">Multigroomer All-in-One</h5>
                  <p class="card-text text-muted">23 Piece Men's Grooming Kit</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$60.00</span>
                    <span class="text-primary fw-bold">$44.00</span>

                  </div>
                </div>
              </div>
            </div>
            <!-- Product 2 -->
            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/16.jpeg')}}" class="card-img-top" alt="Product 2">
                <div class="card-body">
                  <h5 class="card-title">Smart Speaker</h5>
                  <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$250.00</span>
                    <span class="text-primary fw-bold">$219.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Product 3 -->
            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/15.jpeg')}}" class="card-img-top" alt="Product 3">
                <div class="card-body">
                  <h5 class="card-title">Home Speaker 500</h5>
                  <p class="card-text text-muted">Smart Bluetooth Speaker</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$220.00</span>
                    <span class="text-primary fw-bold">$209.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Product 4 -->
            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/10.jpeg')}}" class="card-img-top" alt="Product 4">
                <div class="card-body">
                  <h5 class="card-title">Note 10 Pro</h5>
                  <p class="card-text text-muted">128GB 6GB RAM</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$800.00</span>
                    <span class="text-primary fw-bold">$659.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/11.jpeg')}}" class="card-img-top" alt="Product 2">
                <div class="card-body">
                  <h5 class="card-title">Smart Speaker</h5>
                  <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$250.00</span>
                    <span class="text-primary fw-bold">$219.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/12.jpeg')}}" class="card-img-top" alt="Product 2">
                <div class="card-body">
                  <h5 class="card-title">Smart Speaker</h5>
                  <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$250.00</span>
                    <span class="text-primary fw-bold">$219.00</span>
                  </div>
                </div>
              </div>
            </div>


            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/13.jpeg')}}" class="card-img-top" alt="Product 2">
                <div class="card-body">
                  <h5 class="card-title">Smart Speaker</h5>
                  <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$250.00</span>
                    <span class="text-primary fw-bold">$219.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card h-100 position-relative">
                <img src="{{asset('public/user/images/14.jpeg')}}" class="card-img-top" alt="Product 2">
                <div class="card-body">
                  <h5 class="card-title">Smart Speaker</h5>
                  <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-decoration-line-through">$250.00</span>
                    <span class="text-primary fw-bold">$219.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container py-5">
          <h3 class="fw-bold mb-4">What is everyone saying?</h3>
          <div class="row g-4">
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                      </div>
                      <p>Dolores porro laboriosam molestias est quo. Et et eos. Ab error modi labore sed eaque est.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Rafael Stokes</strong>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                      </div>
                      <p>Dolorem et cumque consequuntur consequuntur cumque eligendi voluptate.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Chelsea Turner</strong>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                          <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                      </div>
                      <p>Et eum neque ipsum quaerat ratione qui dolore eos. Numquam quo vel amet expedita.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Jacqueline Mueller</strong>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                      </div>
                      <p>Itaque dicta rerum aliquam sit corporis iste omnis.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Olive Borer</strong>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                      </div>
                      <p>In saepe veniam. Rerum excepturi dolor voluptatibus.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Priscilla Jacobson</strong>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="border rounded p-4 bg-white">
                      <div class="text-warning mb-2">
                      </div>
                      <p>Saepe doloribus deserunt in. At beatae neque pariatur harum vel.</p>
                      <div class="d-flex align-items-center mt-3">
                          <i class="bi bi-person"></i>
                          <strong>Joseph Reinger</strong>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      </div>
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
      <a href="#" class="link">Check your Order Status</a>
    </div>
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-right-left"></i>
      </div>
      <a href="#" class="link">Returns & Exchanges</a>
    </div>
    <div class="footer-section col-sm-12 col-md-6 col-lg-3">
      <div class="icon">
        <i class="fa-solid fa-dollar-sign"></i></div>
        <a href="#" class="link">Price Match Guarantee</a>
    </div>
  </div>
  <!-- End Footer Top -->
  <hr>

  <div class="footer-bottom row">
    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>Order & Purchases</h4>
      <ul>
        <li><a href="#">Check Order Status</a></li>
        <li><a href="#">Shipping, Delivery & Pickup</a></li>
        <li><a href="#">Returns & Exchanges</a></li>
        <li><a href="#">Price Match Guarantee</a></li>
        <li><a href="#">Product Recalls</a></li>
        <li><a href="#">Trade-in Program</a></li>
        <li><a href="#">Gift Cards</a></li>
      </ul>
    </div>
    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>Support & Services</h4>
      <ul>
        <li><a href="#">Visit our Support Center</a></li>
        <li><a href="#">Contact with an Expert</a></li>
        <li><a href="#">Schedule a Service</a></li>
        <li><a href="#">Manage an Appointment</a></li>
        <li><a href="#">Protection & Support Plans</a></li>
        <li><a href="#">Haul Away & Recycling</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>

    <div class="footer-column col-sm-12 col-md-6 col-lg-3">
      <h4>About Best Buy</h4>
      <ul>
        <li><a href="#">corporate information</a></li>
        <li><a href="#">careers</a></li>
        <li><a href="#">corporate responsibility</a></li>
      </ul>
    </div>

    <div class="footer-column col-sm-12 col-md-6 col-lg-3  footer-Email">
      <span class="footer-sgin-in"><a href="#">Sign in or Create Account</a></span>
      <hr>
      <div class="form-footer-container">
        <h4>Get the latest deals</h4>
        <input type="email" placeholder="Enter email address" />
        <button class="btn btn-primary">Sign Up</button>
      </div>
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="{{URL::asset('public/user/js/jquery-3.7.1.min.js')}}"></script>
  <script src="{{URL::asset('public/user/js/main.js')}}"></script>
</body>
</html>
