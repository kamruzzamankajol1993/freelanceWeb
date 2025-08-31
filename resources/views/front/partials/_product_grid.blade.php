@foreach($products as $product)
<div class="col-6 col-md-4 col-lg-3 col-xl-2">
    <div class="product-card-need position-relative">
        <a href="{{ route('product.show', $product->slug) }}">
            <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                    <img src="{{ $front_ins_url . 'public/uploads/' . $product->thumbnail_image[0] }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
                <div class="product-card">
                    <h6 class="product-name">{{ Str::limit($product->name, 25) }}</h6>
                    <p class="product-price">
                        @if($product->discount_price)
                            ৳ {{ number_format($product->discount_price, 2) }}
                            <del class="text-muted">৳ {{ number_format($product->base_price, 2) }}</del>
                        @else
                            ৳ {{ number_format($product->base_price, 2) }}
                        @endif
                    </p>
                </div>
            </div>
        </a>
        <div class="d-flex add-to-cart-parent justify-content-center">
            <button class="add-btn quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal" data-id="{{ $product->id }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endforeach