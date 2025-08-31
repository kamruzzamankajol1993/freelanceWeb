@extends('front.master.master')

@section('title', 'Your Shopping Cart')

@section('body')
  <section class="page-hero-section px-md-0 px-3">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="page-hero-title">Your Quick Picks</h2>
          <div class="page-hero-nav-links bg-white rounded">
            <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">Shopping Cart</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="basket-product">
    <div class="container my-5">
      <div class="cart-container table-responsive">
        <table class="table align-middle">
          <thead class="fw-bold">
            <tr>
              <th scope="col" style="width:40%">Product</th>
              <th scope="col" style="width:15%">Price</th>
              <th scope="col" style="width:25%">Quantity</th>
              <th scope="col" style="width:15%">Total</th>
              <th scope="col" style="width:5%">Action</th>
            </tr>
          </thead>
          <tbody id="cart-items">
            </tbody>
        </table>

        <div id="cart-summary" class="d-flex justify-content-between align-items-center mt-4">
            </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartSummaryContainer = document.getElementById('cart-summary');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Main function to fetch and render the entire cart
     function renderCart() {
        const publicurl = '{{ $front_ins_url . 'public/uploads/' }}';
        cartItemsContainer.innerHTML = `<tr><td colspan="5" class="text-center">Loading cart...</td></tr>`;

        fetch('{{ route('cart.content') }}')
            .then(response => response.json())
            .then(data => {
                cartItemsContainer.innerHTML = ''; // Clear loading message
                if (Object.keys(data.items).length > 0) {
                    for (const key in data.items) {
                        const item = data.items[key];
                        const price = parseFloat(item.price);
                        const itemTotal = (price * item.quantity).toFixed(2);

                        // =================== MODIFICATION START ===================
                        // Check for color and size and build a details string
                        let variantDetails = '';
                        if (item.color_name) {
                            variantDetails += `<small class="d-block text-muted">Color: ${item.color_name}</small>`;
                        }
                        if (item.size_name) {
                            variantDetails += `<small class="d-block text-muted">Size: ${item.size_name}</small>`;
                        }
                        
                        const row = `
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="${publicurl}${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px;">
                                        <div>
                                            <span class="fw-bold">${item.name}</span>
                                            ${variantDetails}
                                        </div>
                                    </div>
                                </td>
                        
                                <td>৳${price.toFixed(2)}</td>
                                <td>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary btn-minus" type="button" data-cart-key="${key}">-</button>
                                        <input type="text" class="form-control text-center quantity-input" value="${item.quantity}" readonly data-cart-key="${key}">
                                        <button class="btn btn-outline-secondary btn-plus" type="button" data-cart-key="${key}">+</button>
                                    </div>
                                </td>
                                <td>৳${itemTotal}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger remove-item-btn" data-cart-key="${key}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        cartItemsContainer.innerHTML += row;
                    }
                    
                    cartSummaryContainer.innerHTML = `
                        <div>
                            <button class="btn btn-danger" id="clear-cart-btn">Clear Cart</button>
                        </div>
                        <div class="text-end">
                            <h4>Subtotal: ৳${data.subtotal.toFixed(2)}</h4>
                            <a href="#" class="btn btn-primary btn-lg hero-btn mt-2">Continue to checkout</a>
                        </div>
                    `;

                } else {
                    cartItemsContainer.innerHTML = `<tr><td colspan="5" class="text-center py-5">Your cart is empty.</td></tr>`;
                    cartSummaryContainer.innerHTML = '';
                }
                updateCartCounter(); // Update header count
            })
            .catch(error => console.error('Error rendering cart:', error));
    }

    // Function to handle cart actions (update, remove, clear)
    function handleCartAction(url, method, body) {
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                renderCart(); // Re-render the cart on success
            } else {
                alert(result.message || 'An error occurred.');
            }
        })
        .catch(error => console.error('Cart action error:', error));
    }

    // Event Delegation for item removal and quantity changes
    cartItemsContainer.addEventListener('click', function(e) {
        const removeButton = e.target.closest('.remove-item-btn');
        const plusButton = e.target.closest('.btn-plus');
        const minusButton = e.target.closest('.btn-minus');

        if (removeButton) {
            const cartKey = removeButton.dataset.cartKey;
            if (confirm('Are you sure you want to remove this item?')) {
                handleCartAction('{{ route('cart.remove') }}', 'POST', { cart_key: cartKey });
            }
            return;
        }

        if (plusButton) {
            const cartKey = plusButton.dataset.cartKey;
            const input = plusButton.parentElement.querySelector('.quantity-input');
            const newQuantity = parseInt(input.value) + 1;
            handleCartAction('{{ route('cart.update') }}', 'POST', { cart_key: cartKey, quantity: newQuantity });
            return;
        }

        if (minusButton) {
            const cartKey = minusButton.dataset.cartKey;
            const input = minusButton.parentElement.querySelector('.quantity-input');
            const newQuantity = parseInt(input.value) - 1;

            if (newQuantity > 0) {
                handleCartAction('{{ route('cart.update') }}', 'POST', { cart_key: cartKey, quantity: newQuantity });
            }
        }
    });

    // Event listener for the "Clear Cart" button
    cartSummaryContainer.addEventListener('click', function(e) {
        if (e.target.id === 'clear-cart-btn') {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                handleCartAction('{{ route('cart.clear') }}', 'POST', {});
            }
        }
    });

    // Initial render of the cart on page load
    renderCart();
});
</script>
@endsection