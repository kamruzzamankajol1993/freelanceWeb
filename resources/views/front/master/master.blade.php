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
   @if (!empty($pixelId))
  <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{$pixelId}}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{$pixelId}}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endif
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


  <!-- login modal -->
   @include('front.include.login')
  </main>

  @include('front.include.footer')
  

    <!-- modal area -->
  

    <!-- register modal -->
    @include('front.include.register')

    <!-- otp modal -->
     @include('front.include.otp')

     <!-- password -->

 @include('front.include.password')
 @include('front.include.passwordChangeOtp')
 @include('front.include.passwordChange')

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
  <script src="{{asset('/')}}public/front/assets/js/script.js"></script>
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <script>
        // ++ ADD THIS SCRIPT TO CONFIGURE TOASTR'S DEFAULT BEHAVIOR ++
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        }

        //
        function updateCartCounter() {
        fetch('{{ route('cart.content') }}')
            .then(response => response.json())
            .then(data => {
                const cartCountEl = document.getElementById('cart-item-count');
                if (cartCountEl) {
                    cartCountEl.textContent = data.totalItems || 0;
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }
    </script>
  @yield('script')
</body>

</html>