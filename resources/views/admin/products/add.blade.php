<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{URL::asset('public/admin/css/master.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/admin/css/products.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/admin/css/orders.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/admin/css/user.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/admin/css/editor.css')}}">
</head>
  <body>
    <div class="container" >
      <header class="header">
        <h1 class="site-name">SHOP AND BUY</h1>
          <div class="header-right-side">
            <i class="fa-regular fa-sun"></i>
            <i class="fa-regular fa-moon"></i>
            <a class="header-profile" href="#"><i class="fa-solid fa-user-large"></i></a>
          </div>
        </header>
        <main class="titel_form">
          <h1>Add New Product</h1>

        </div>
    <div class="only-form">
      <form action="{{route('admin.product.post')}}"  method="post" class="add_user" enctype="multipart/form-data">
        @csrf
          <div class="two-input">
            <div class="input-div w-half">
              <label for="title" class="riq">Title</label>
              <input type="text" id="title" name="title" placeholder="Enter Product Title">
            </div>
            <div class="input-div w-half">
              <label for="price" class="riq">Price</label>
              <input type="number" id="price" name="price" placeholder="Enter Product Price">
            </div>
          </div>
          <div class="two-input">
            <div class="input-div">
              <label for="sale_price" class="riq">Sale Price</label>
              <input type="number" id="sale_price" name="sale_price" placeholder="Sale Price">
            </div>
          </div>
          <div class="product_editor">
            <div class="image-upload">
                <i class="fa-regular fa-image"></i>
              <input  type="file" name="image" class="fileInput" accept="image/*" >
              <span class="Upload_image">Upload image</span>
            </div>
          </div>

          <button type="submit" >Add Product</button>
        </form>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{URL::asset('public/admin/js/main.js')}}"></script>
    @include('admin.messages.success')
    @include('admin.messages.error')
  </body>
</html>
