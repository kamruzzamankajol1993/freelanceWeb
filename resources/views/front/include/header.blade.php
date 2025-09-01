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
              <a href="{{route('home.index')}}"><img src="{{$front_ins_url}}{{$front_logo_name}}" alt=""></a>
            </div>
          </div>

          <!-- Search Bar -->
          <div class="search-container d-none d-md-flex">
            <div class="search-wrapper">
              <i class="fas fa-search search-icon"></i>
              <input type="search" id="search" name="search" autocomplete="off" class="form-control search-input" placeholder="Search Product Here">
              <!-- Search Results Dropdown -->
              <div id="search-results" class="search-results-container"></div>
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
            <a href="{{route('cart.show')}}">
              <div class="cart-icon px-lg-3 me-3">
                <img src="{{asset('/')}}public/front/assets/img/cart.png" alt="">
                <span class="cart-badge" id="cart-item-count">0</span>
              </div>
            </a>
            @if (!Auth::check()) 
            <!-- User Profile -->
            <div class="user-icon d-none d-md-block" data-bs-toggle="modal" data-bs-target="#loginModal" style="cursor: pointer;">
              <img src="{{asset('/')}}public/front/assets/img/user.png" alt="">
            </div>
            @else
            <div class="user-icon d-none d-md-block">
                <a href="{{route('dashboard.user')}}">  <img src="{{asset('/')}}public/front/assets/img/user.png" alt=""></a>
            </div>
            @endif
          </div>
        </div>
      </nav>
    </header>

<style>
/* --- STYLES FOR LIVE SEARCH RESULTS --- */
.search-wrapper {
    position: relative;
}
.search-results-container {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-top: none;
    border-radius: 0 0 .25rem .25rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none; /* Hidden by default */
}
.search-result-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: #333;
    border-bottom: 1px solid #f0f0f0;
}
.search-result-item:hover {
    background-color: #f8f9fa;
}
.search-result-item:last-child {
    border-bottom: none;
}
.search-result-item img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    margin-right: 10px;
    border-radius: 4px;
}
.search-result-item .product-name {
    font-size: 0.9rem;
}
.no-results {
    padding: 1rem;
    text-align: center;
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global function to update the header cart counter
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
    updateCartCounter();

    // --- LIVE SEARCH SCRIPT ---
    const searchInput = document.getElementById('search');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('keyup', function() {
        const query = this.value;

        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        fetch(`{{ route('product.search') }}?query=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = ''; // Clear previous results
                if (data.length > 0) {
                    data.forEach(product => {
                        const productUrl = '{{ url('product') }}/' + product.slug;
                        const item = `
                            <a href="${productUrl}" class="search-result-item">
                                <img src="${product.main_image}" alt="${product.name}">
                                <span class="product-name">${product.name}</span>
                            </a>
                        `;
                        searchResults.innerHTML += item;
                    });
                } else {
                    searchResults.innerHTML = '<div class="no-results">No products found.</div>';
                }
                searchResults.style.display = 'block';
            })
            .catch(error => console.error('Error fetching search results:', error));
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
});
</script>
