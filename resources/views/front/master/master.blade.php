<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title')</title>
    <meta name="description" content="{{$front_ins_name}}">
    <meta name="keywords" content="{{$front_ins_name}}">
    <meta name="author" content="{{$front_ins_name}}">
    <link rel="canonical" href="{{url()->current()}}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:title" content="{{$front_ins_name}}">
    <meta property="og:description" content="{{$front_ins_name}}">
    <meta property="og:image" content="{{$front_ins_url}}{{$front_icon_name}}">

<!-- Favicon -->
    <link rel="shortcut icon" href="{{$front_ins_url}}{{ $front_icon_name }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="{{asset('/')}}public/front/assets/style.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/')}}public/front/assets/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @if(Route::is('home.index'))
  <script src="{{asset('/')}}public/front/assets/js/script.js"></script>
  @endif
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <script>
        // ++ ADD THIS SCRIPT TO CONFIGURE TOASTR'S DEFAULT BEHAVIOR ++
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        }
    </script>
  @yield('script')
</body>

</html>