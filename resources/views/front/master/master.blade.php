<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="{{asset('/')}}public/front/assets/style.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/')}}public/front/assets/responsive.css">
  <link rel="shortcut icon" href="./assets/img/Favicon.png" type="image/icon" sizes="96x96 96x96">
  @yield('css')
</head>

<body>
  <!-- Sidebar -->
  @include('front.include.sidebar')

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <!-- Header -->
  <main class="px-lg-5 px-md-4">
    @include('front.include.header')


    

@yield('body')



  </main>

  @include('front.include.footer')
  

    <!-- modal area -->
    <!-- login modal -->
   @include('front.include.login')

    <!-- register modal -->
    @include('front.include.register')

    <!-- otp modal -->
     @include('front.include.otp')

     <!-- password -->

 @include('front.include.password')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('/')}}public/front/assets/js/script.js"></script>
  @yield('script')
</body>

</html>