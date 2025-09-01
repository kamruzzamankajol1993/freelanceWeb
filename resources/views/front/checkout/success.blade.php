@extends('front.master.master')

@section('title', 'Order Successful')

@section('css')
<style>
    .success-icon {
        font-size: 5rem;
        color: #28a745;
    }
    .order-summary-card {
        border: 1px solid #e9ecef;
        border-radius: .75rem;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: .5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .summary-item:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('body')
 <!-- Hero Section -->
    <section class="page-hero-section px-md-0 px-3">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="page-hero-title">Thank You For Your Order!</h2>
            <div class="page-hero-nav-links bg-white rounded">
              <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">Order Confirmation</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Success Content -->
    <section class="checkout-section overflow-hidden py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle success-icon"></i>
                        <h3 class="mt-3">Your order has been placed successfully.</h3>
                        <p class="text-muted">A confirmation email has been sent to {{ $order->customer->email ?? '' }}.</p>
                    </div>

                    <div class="order-summary-card p-4">
                        <h5 class="text-center mb-4 border-bottom pb-3">Order Summary</h5>
                        
                        <div class="summary-item">
                            <strong>Order Number:</strong>
                            <span>#{{ $order->invoice_no }}</span>
                        </div>
                        <div class="summary-item">
                            <strong>Order Date:</strong>
                            <span>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="summary-item">
                            <strong>Total Amount:</strong>
                            <span>৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <strong>Payment Method:</strong>
                            <span>{{ ucfirst($order->payment_method) }}</span>
                        </div>

                        <div class="mt-4">
                            <h6><strong>Shipping Address</strong></h6>
                            <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('shop.show') }}" class="btn btn-primary access-now-btn">Continue Shopping</a>
                            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-secondary">View Order in Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
