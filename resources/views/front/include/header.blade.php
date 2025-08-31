<header class="main-header">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <!-- Sidebar Toggle -->
          <button class="sidebar-toggle" onclick="toggleSidebar()">
            <img src="{{asset('/')}}public/front/assets/img/menu.png" alt="">
          </button>

          <!-- Logo -->
          <div class="navbar-brand px-lg-4">
            <div class="logo">
              <a href="index.html"><img src="{{asset('/')}}public/front/assets/img/logo.png" alt=""></a>
            </div>
          </div>

          <!-- Search Bar -->
          <div class="search-container d-none d-md-flex">
            <div class="search-wrapper">
              <i class="fas fa-search search-icon"></i>
              <input type="search" id="search" name="search" class="form-control search-input" placeholder="Search Your Dream">
            </div>
          </div>

          <!-- Right Side Items -->
          <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
            <!-- Order Now Text -->
            <div class="order-text d-none d-lg-flex align-items-center me-3">
              <i class="fas fa-bolt text-primary me-2"></i>
              <span>Order now and get it <span class="text-primary">ASAP!</span></span>
            </div>

            <!-- Cart -->
            <a href="basket.html">
              <div class="cart-icon px-lg-3 me-3">
                <img src="{{asset('/')}}public/front/assets/img/cart.png" alt="">
                <span class="cart-badge">02</span>
              </div>
            </a>

            <!-- User Profile -->
            <div class="user-icon d-none d-md-block" data-bs-toggle="modal" data-bs-target="#loginModal" style="cursor: pointer;">
              <img src="{{asset('/')}}public/front/assets/img/user.png" alt="">
            </div>
          </div>
        </div>
      </nav>
    </header>