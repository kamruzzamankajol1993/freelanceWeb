@extends('front.master.master')

@section('title', 'Secure Checkout')

@section('css')
<style>
    /* Add a visual cue for the selected delivery option */
    .pick-checkout-delivery-option {
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s ease-in-out;
    }
    .pick-checkout-delivery-option.active {
        border-color: #0d6efd; /* Bootstrap primary color */
    }
    /* Styles for the new success modal */
    .success-modal-icon {
        width: 80px;
        height: 80px;
        background-color: #e8f5e9; /* Light green */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .success-modal-icon svg {
        width: 40px;
        height: 40px;
        color: #28a745; /* Bootstrap success green */
    }
</style>
@endsection

@section('body')
  <section class="page-hero-section px-md-0 px-3">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="page-hero-title">You're Almost There!</h2>
            <div class="page-hero-nav-links bg-white rounded">
              <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">Secure Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="checkout-section overflow-hidden">
      <form id="checkoutForm" action="{{ route('checkout.place.order') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="pick-checkout-container">
             
                 <!-- Progress Steps -->
            <div class="d-md-flex align-items-center justify-content-between px-md-0 px-3">
              <h4>Secure Checkout</h4>
              <div class="pick-checkout-progress-steps">
                <div class="pick-checkout-step completed">
                  <div class="pick-checkout-step-number"><img src="{{asset('/')}}public/front/assets/img/tick.png" alt=""></div>
                  <span>Basket</span>
                </div>
                <div class="step-divider d-lg-block d-none"></div>
                <div class="pick-checkout-step completed">
                  <div class="pick-checkout-step-number"><img src="{{asset('/')}}public/front/assets/img/tick.png" alt=""></div>
                  <span>Review</span>
                </div>
                <div class="step-divider d-lg-block d-none"></div>
                <div class="pick-checkout-step active">
                  <div class="pick-checkout-step-number">3</div>
                  <span>Secure Checkout</span>
                </div>
                <div class="step-divider d-lg-block d-none"></div>
                <div class="pick-checkout-step">
                  <div class="pick-checkout-step-number">4</div>
                  <span>Confirm</span>
                </div>
              </div>
            </div>
              </div>

              <div id="checkout-errors" class="alert alert-danger mx-3" style="display: none;"></div>


              <div class="row border-top">
                <div class="col-lg-6">
                  <div class="pick-checkout-shipping-section">
                    <h4 class="pick-checkout-section-title pt-3">Shipping Information</h4>
                       <div class="pick-checkout-delivery-options">
                      <div class="pick-checkout-delivery-option active d-flex gap-1 justify-content-center align-items-center" data-delivery-type="delivery">
                        <img src="{{asset('/')}}public/front/assets/img/trucks.png" alt="Delivery Truck">
                        <div>Delivery</div>
                      </div>
                      <div class="pick-checkout-delivery-option d-flex gap-1 justify-content-center align-items-center" data-delivery-type="pickup">
                        <img src="{{asset('/')}}public/front/assets/img/boxx.png" alt="Pickup Box">
                        <div>Pick Up</div>
                      </div>
                    </div>

                    <input type="hidden" name="delivery_type" id="delivery_type" value="delivery">
                    
                      <div class="row">
                        <div class="col-12 mb-3">
                          <label class="pick-checkout-form-label">Full Name *</label>
                          <input type="text" class="form-control pick-checkout-form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                        </div>

                        <div class="col-12 mb-3">
                          <label class="pick-checkout-form-label">Email *</label>
                          <input type="email" class="form-control pick-checkout-form-control" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        </div>

                        <div class="col-12 mb-3">
                          <label class="pick-checkout-form-label">Phone Number *</label>
                          <input type="tel" class="form-control pick-checkout-form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                        </div>

                         <div class="col-12 mb-3">
                            <label class="pick-checkout-form-label">Shipping Area *</label>
                            <select name="shipping_area" id="shipping_area" class="form-select pick-checkout-form-select" required>
                                <option value="" disabled selected>Select Area</option>
                                <option value="70">Inside Dhaka (৳70)</option>
                                <option value="130">Outside Dhaka (৳130)</option>
                            </select>
                         </div>

                        <div class="col-6 mb-3">
                          <label class="pick-checkout-form-label">Billing Address *</label>
                          <textarea name="billing_address" required class="form-control">{{ old('billing_address', $billingAddress->address ?? $user->address ?? '') }}</textarea>
                        </div>

                        <div class="col-6 mb-3">
                          <label class="pick-checkout-form-label">Shipping Address *</label>
                          <textarea name="shipping_address" required class="form-control">{{ old('shipping_address', $shippingAddress->address ?? $billingAddress->address ?? $user->address ?? '') }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                          <label class="pick-checkout-form-label">Order Note</label>
                          <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                        </div>
                      </div>

                      <div class="pick-checkout-terms-checkbox">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                          <label class="form-check-label" for="terms">
                            I have read and agree to the Terms & Conditions
                          </label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="pick-checkout-product-section">
                    <h4 class="pick-checkout-section-title pt-3">Your Picks, Ready to Go</h4>
                    @foreach($cartItems as $item)
                    <div class="pick-checkout-product-card">
                      <div class="pick-checkout-product-info">
                        <div class="checkout-img-wrapper">
                          <img src="{{ $front_ins_url . 'public/uploads/'.$item['image'] }}" alt="{{ $item['name'] }}" class="pick-checkout-product-image">
                        </div>
                        <div class="pick-checkout-product-details">
                          <h6>{{ $item['name'] }}</h6>
                          @if(!empty($item['color_name']))<div>Color: {{ $item['color_name'] }}</div>@endif
                          @if(!empty($item['size_name']))<div>Size: {{ $item['size_name'] }}</div>@endif
                          <div class="checkout-qty">Qty: {{ $item['quantity'] }}x</div>
                          <div class="pick-checkout-price">Price: ৳{{ number_format($item['price'], 2) }}</div>
                        </div>
                      </div>
                    </div>
                    @endforeach

                    <div class="pick-checkout-payment-section">
                      <div class="mb-3">
                        <label class="pick-checkout-form-label">Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-select pick-checkout-form-select">
                          <option value="cod" selected>Cash On Delivery</option>
                          <option value="bkash">Bkash</option>
                          <option value="nagad">Nagad</option>
                          <option value="rocket">Rocket</option>
                        </select>
                      </div>

                      <!-- Mobile Payment Fields (Initially Hidden) -->
                      <div id="mobile-payment-fields" style="display: none;">
                          <div class="mb-3">
                            <label class="pick-checkout-form-label">Your <span id="payment-method-name"></span> Number</label>
                            <input type="text" name="payment_phone" class="form-control pick-checkout-form-control" placeholder="Enter Your Number">
                          </div>

                          <div class="mb-3">
                            <label class="pick-checkout-form-label">Transaction ID</label>
                            <input type="text" name="payment_trxid" class="form-control pick-checkout-form-control" placeholder="Enter Transaction ID">
                          </div>
                      </div>

                      <div class="mb-3">
                        <label class="pick-checkout-form-label">Coupon Code</label>
                        <div id="coupon-area">
                            @if($coupon)
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control coupon-input" value="{{ $coupon->code }}" readonly>
                                    <button type="button" id="remove-coupon-btn" class="btn btn-danger btn-sm ms-2">Remove</button>
                                </div>
                            @else
                                <div class="coupon-input-wrapper position-relative">
                                    <span class="coupon-icon"><img src="{{asset('/')}}public/front/assets/img/code-generate.png" alt=""></span>
                                    <input type="text" id="coupon-code-input" class="form-control coupon-input" placeholder="Enter Coupon Code">
                                    <span class="apply-text" id="apply-coupon-btn">Apply</span>
                                </div>
                            @endif
                        </div>
                        <div id="coupon-message" class="small mt-1"></div>
                      </div>

                      <div class="pick-checkout-price-breakdown">
                        <div class="pick-checkout-price-row">
                          <span class="sub-total">Subtotal</span>
                          <span id="subtotal-amount">৳{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="pick-checkout-price-row">
                          <span class="shipping">Shipping</span>
                          <span id="shipping-amount">৳{{ number_format($shippingCost, 2) }}</span>
                        </div>
                        <div class="pick-checkout-price-row">
                          <span class="discount">Discount</span>
                          <span id="discount-amount">৳{{ number_format($discount, 2) }}</span>
                        </div>
                        <div class="pick-checkout-price-row total">
                          <span>Total</span>
                          <span id="total-amount">৳{{ number_format($total, 2) }}</span>
                        </div>
                      </div>

                      <div class="d-flex justify-content-center">
                        <button type="submit" id="placeOrderBtn" class="pick-checkout-pay-now-btn">
                          Place Order - <span id="pay-now-total">৳{{ number_format($total, 2) }}</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>

    <!-- SUCCESS MODAL -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="modal-header border-0">
             <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href='{{ route('home.index') }}'"></button>
          </div>
          <div class="modal-body">
            <div style="text-align: center; padding: 20px;">
                        <div>
                            <img style="width:50px" src="{{asset('/')}}public/front/assets/img/step-done.png"/>
                        </div>
                        <h4 class="mt-3" style="color: #212529; font-weight: 600; margin-bottom: 15px;">Woohoo! Payment Received</h2>
                        <p style="color: #42444D; margin-bottom: 25px; line-height: 1.5; font-size:15px">
                            Thank you for your purchase!<br>
                            Your order is being processed and will be on its way shortly. <br>
                            You'll receive a confirmation email with the details soon.
                        </p>
                        <button onclick="printInvoice()"
                          style="background: #f2fbff; color: #00AAFF; border: none; padding: 12px 24px; border-radius:
                          6px; font-weight: 500; cursor: pointer; border: 1px solid #00AAFF;">
                            Print Invoice
                        </button>
                    </div>
            {{-- <a href="#" id="printInvoiceBtn" class="btn btn-outline-primary mt-3" style="display: none;">Print Invoice</a> --}}
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- NEW SCRIPT FOR DELIVERY TYPE SELECTION ---
    const deliveryOptions = document.querySelectorAll('.pick-checkout-delivery-option');
    const deliveryTypeInput = document.getElementById('delivery_type');

    deliveryOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove 'active' class from all options
            deliveryOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add 'active' class to the clicked option
            this.classList.add('active');
            
            // Update the hidden input's value
            const selectedType = this.dataset.deliveryType;
            deliveryTypeInput.value = selectedType;

            console.log('Selected Delivery Type:', selectedType); // For debugging
        });
    });

    // ... your other existing scripts ...
});
</script>
<script>

   // This variable must be in the global scope so the printInvoice function can access it.
    let successfulOrderId = null;

    // This function is moved to the global scope so the button's onclick attribute can find it.
    function printInvoice() {
        if (successfulOrderId) {
            // Create a URL template using the route() helper with a placeholder ('__ID__').
            let urlTemplate = "{{ route('invoice.print', ['order' => '__ID__']) }}";
            
            // Use JavaScript's replace() method to substitute the placeholder with the actual order ID.
            const url = urlTemplate.replace('__ID__', successfulOrderId);

            // Open the final, correct URL in a new tab.
            window.open(url, '_blank');
        } else {
            alert('Could not find the order ID. Please refresh the page.');
        }
    }

  // Delivery option toggle
    document.querySelectorAll('.pick-checkout-delivery-option').forEach(option => {
      option.addEventListener('click', function () {
        document.querySelectorAll('.pick-checkout-delivery-option').forEach(opt => opt.classList.remove(
          'active'));
        this.classList.add('active');
      });
    });
document.addEventListener('DOMContentLoaded', function () {
    const shippingAreaSelect = document.getElementById('shipping_area');
     const paymentTypeSelect = document.getElementById('payment_type');
    const mobilePaymentFields = document.getElementById('mobile-payment-fields');
    const paymentMethodName = document.getElementById('payment-method-name');
    const csrfToken = '{{ csrf_token() }}';
    
    // --- AJAX Function to update totals on the page ---
    function updateTotals(totals) {
        document.getElementById('subtotal-amount').textContent = '৳' + parseFloat(totals.subtotal).toFixed(2);
        document.getElementById('shipping-amount').textContent = '৳' + parseFloat(totals.shippingCost).toFixed(2);
        document.getElementById('discount-amount').textContent = '৳' + parseFloat(totals.discount).toFixed(2);
        document.getElementById('total-amount').textContent = '৳' + parseFloat(totals.total).toFixed(2);
        document.getElementById('pay-now-total').textContent = '৳' + parseFloat(totals.total).toFixed(2);
    }

      paymentTypeSelect.addEventListener('change', function() {
        const selectedMethod = this.value;
        const phoneInput = mobilePaymentFields.querySelector('input[name="payment_phone"]');
        const trxIdInput = mobilePaymentFields.querySelector('input[name="payment_trxid"]');

        if (selectedMethod === 'bkash' || selectedMethod === 'nagad' || selectedMethod === 'rocket') {
            paymentMethodName.textContent = selectedMethod.charAt(0).toUpperCase() + selectedMethod.slice(1);
            mobilePaymentFields.style.display = 'block';
            phoneInput.required = true;
            trxIdInput.required = true;
        } else {
            mobilePaymentFields.style.display = 'none';
            phoneInput.required = false;
            trxIdInput.required = false;
        }
    });
    
    // --- Handle Shipping Area Change ---
    shippingAreaSelect.addEventListener('change', function () {
        const shippingCost = this.value;
        if (shippingCost === "") return; // Do nothing if placeholder is selected

        // This script now relies on the SERVER to do the math, which is more reliable.
        fetch("{{ route('checkout.shipping.update') }}", {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify({ shipping_cost: shippingCost })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateTotals(data.totals);
            }
        })
        .catch(err => {
            console.error('Shipping update error:', err);
            alert('Could not update shipping cost. Please try again.');
        });
    });

    // --- Handle Coupon Apply/Remove ---
    document.getElementById('coupon-area').addEventListener('click', function(e) {
        const couponMessage = document.getElementById('coupon-message');
        
        // APPLY COUPON
        if (e.target && e.target.id === 'apply-coupon-btn') {
            const couponInput = document.getElementById('coupon-code-input');
            const code = couponInput.value.trim();
            if (!code) {
                couponMessage.textContent = 'Please enter a coupon code.';
                couponMessage.className = 'text-danger small mt-1';
                return;
            }
            e.target.textContent = 'Applying...';
            
            fetch("{{ route('checkout.coupon.apply') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ code: code, shipping_cost: shippingAreaSelect.value || 0 })
            })
            .then(res => res.json())
            .then(data => {
                couponMessage.textContent = data.message;
                if(data.success) {
                    couponMessage.className = 'text-success small mt-1';
                    updateTotals(data.totals);
                    document.getElementById('coupon-area').innerHTML = `
                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control coupon-input" value="${data.totals.coupon.code}" readonly>
                            <button type="button" id="remove-coupon-btn" class="btn btn-danger btn-sm ms-2">Remove</button>
                        </div>
                    `;
                } else {
                    couponMessage.className = 'text-danger small mt-1';
                    e.target.textContent = 'Apply';
                }
            })
            .catch(err => {
                 couponMessage.textContent = 'An error occurred.';
                 couponMessage.className = 'text-danger small mt-1';
                 e.target.textContent = 'Apply';
            });
        }

        // REMOVE COUPON
        if (e.target && e.target.id === 'remove-coupon-btn') {
             fetch("{{ route('checkout.coupon.remove') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ shipping_cost: shippingAreaSelect.value || 0 })
            })
            .then(res => res.json())
            .then(data => {
                couponMessage.textContent = data.message;
                couponMessage.className = 'text-info small mt-1';
                updateTotals(data.totals);
                document.getElementById('coupon-area').innerHTML = `
                    <div class="coupon-input-wrapper position-relative">
                        <span class="coupon-icon"><img src="{{asset('/')}}public/front/assets/img/code-generate.png" alt=""></span>
                        <input type="text" id="coupon-code-input" class="form-control coupon-input" placeholder="Enter Coupon Code">
                        <span class="apply-text" id="apply-coupon-btn">Apply</span>
                    </div>
                `;
            });
        }
    });

    // --- AJAX FORM SUBMISSION FOR PLACING ORDER ---
    const checkoutForm = document.getElementById('checkoutForm');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const checkoutErrors = document.getElementById('checkout-errors');
// let successfulOrderId = null; 
    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const originalBtnText = placeOrderBtn.innerHTML;
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Placing Order...`;
            checkoutErrors.style.display = 'none';
            checkoutErrors.innerHTML = '';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    // const printBtn = document.getElementById('printInvoiceBtn');
                    // printBtn.href = `/invoice/${data.order_id}`; // Example
                      successfulOrderId = data.order_id; 
                    successModal.show();
                    updateCartCounter();
                } else {
                    let errorHtml = '<ul>';
                    if(data.errors){
                        for(const error in data.errors){
                            errorHtml += `<li>${data.errors[error][0]}</li>`;
                        }
                    } else {
                        errorHtml += `<li>${data.message || 'An error occurred.'}</li>`;
                    }
                    errorHtml += '</ul>';
                    checkoutErrors.innerHTML = errorHtml;
                    checkoutErrors.style.display = 'block';
                    window.scrollTo(0, 0); // Scroll to top to see errors
                }
            })
            .catch(error => {
                console.error('Order placement error:', error);
                checkoutErrors.innerHTML = 'A server error occurred. Please try again.';
                checkoutErrors.style.display = 'block';
            })
            .finally(() => {
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerHTML = originalBtnText;
            });
        });

        
    }

   
});
</script>
@endsection