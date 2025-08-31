<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo">
        <a href="{{route('home.index')}}"><img src="{{$front_ins_url}}{{$front_logo_name}}" alt=""></a>
      </div>
      <button class="btn-close-sidebar" onclick="toggleSidebar()">
        <img src="{{asset('/')}}public/front/assets/img/cross.png" alt="">
      </button>
    </div>
    <div class="sidebar-content">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="{{route('home.index')}}"> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about-us.html"> About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('shop.show') }}">Products</a>
        </li>
        {{-- START: DYNAMIC CATEGORY LIST --}}
        @if($categories->isNotEmpty())
            @foreach($categories as $category)
                <li class="nav-item">
                  {{-- The route 'category.show' is used from your web.php file --}}
                  <a class="nav-link" href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        @endif
        {{-- END: DYNAMIC CATEGORY LIST --}}

        <div class="divider"></div>

        <li class="nav-item">
          <a class="nav-link fw-bold" href="profile.html"><img src="{{asset('/')}}public/front/assets/img/account.svg" alt="">Accounts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold" href="order-tarcking.html"><img src="{{asset('/')}}public/front/assets/img/locate.png" alt="">Order
            Tracking</a>
        </li>
      </ul>
    </div>
  </div>