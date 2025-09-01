<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo">
        <a href="{{route('home.index')}}"><img src="{{$front_ins_url}}{{$front_logo_name}}" alt="Logo"></a>
      </div>
      <button class="btn-close-sidebar" onclick="toggleSidebar()">
        <img src="{{asset('/')}}public/front/assets/img/cross.png" alt="Close">
      </button>
    </div>
    <div class="sidebar-content">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="{{route('home.index')}}"> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('about-us')}}"> About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('shop.show') }}">Products</a>
        </li>
        {{-- START: DYNAMIC CATEGORY LIST --}}
        @if(isset($categories) && $categories->isNotEmpty())
            @foreach($categories as $category)
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        @endif
        {{-- END: DYNAMIC CATEGORY LIST --}}

        <div class="divider"></div>

        <li class="nav-item">
          <a class="nav-link fw-bold" href="{{route('dashboard.user')}}"><img src="{{asset('/')}}public/front/assets/img/account.svg" alt="">Accounts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold" href="{{route('orderTracking')}}"><img src="{{asset('/')}}public/front/assets/img/locate.png" alt="">Order
            Tracking</a>
        </li>
      </ul>
    </div>
  </div>

<style>
    .sidebar {
        /* Your existing sidebar styles are here */
        display: flex;
        flex-direction: column;
        height: 100vh; /* Make sidebar take full viewport height */
    }

    .sidebar-header {
        /* This part does not scroll */
        flex-shrink: 0; 
    }

    .sidebar-content {
        /* This is the key part */
        flex-grow: 1; /* Allows this div to take up the remaining space */
        overflow-y: auto; /* Adds a vertical scrollbar ONLY when needed */
        padding-bottom: 20px; /* Adds some space at the very bottom */
    }

    /* Optional: Style the scrollbar for a better look (works in WebKit browsers) */
    .sidebar-content::-webkit-scrollbar {
        width: 8px;
    }

    .sidebar-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
