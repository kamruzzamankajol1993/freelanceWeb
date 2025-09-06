@extends('front.master.master')

@section('title')
{{ $product->name }}
@endsection

@section('css')
<style>
    .sizes .size-option {
        display: inline-block;
        border: 1px solid #ddd;
        padding: 6px 18px;
        margin-right: 10px;
        margin-bottom: 10px;
        border-radius: 25px; /* Pill shape */
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        font-weight: 500;
        background-color: #f8f9fa;
    }

    .sizes .size-option:hover {
        border-color: #333;
        background-color: #e9ecef;
    }

    .sizes .size-option.active {
        background-color: #212529; /* Dark background for active */
        color: #fff; /* White text for active */
        border-color: #212529;
    }
</style>
@endsection

@section('body')
<section class="page-hero-section px-md-0 px-3">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="page-hero-title">Picked Just for You</h2>
                <div class="page-hero-nav-links bg-white rounded">
                    <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">View Product</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="p-md-5 product-details-area rounded">
        <div class="row g-4">
            <div class="col-lg-6 col-md-12">
                <div class="product-image-section">

                    <div class="main-image-container rounded">
                        <img src="{{ $front_ins_url . 'public/uploads/' . ($product->main_image[0] ?? '') }}" alt="{{ $product->name }}" class="main-product-image" id="mainImage">
                    </div>

                    <div class="thumbnail-container mt-3">
                        <div class="row g-2">
                            @if($product->main_image && is_array($product->main_image))
                                @foreach ($product->main_image as $image)
                                    <div class="col-3">
                                        <div class="single-img p-3 d-flex justify-content-center rounded" onclick="changeImage(this, '{{ $front_ins_url . 'public/uploads/' . $image }}')">
                                            <img src="{{ $front_ins_url . 'public/uploads/' . $image }}" alt="{{ $product->name }} thumbnail" class="thumbnail-image">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="product-details-section">
                    <h2 class="product-title mb-2">{{ $product->name }}</h2>

                    <div class="rating-section mb-3">
                        <div class="stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="rating-text ms-2 mb-0">4.5 Rating <span>(120 Review)</span></p>
                    </div>

                    <div class="price-section mb-3">
                        {{-- The content of this span will be updated by JavaScript --}}
                        <span class="current-price" id="productPrice">
                            <img src="{{ asset('public/front/assets/img/taka-icon.png') }}" alt="">
                            @if($product->discount_price)
                                {{ number_format($product->discount_price, 2) }}
                                <span class="original-price text-decoration-line-through text-muted fs-5 ms-2">{{ number_format($product->base_price, 2) }}</span>
                            @else
                                {{ number_format($product->base_price, 2) }}
                            @endif
                        </span>
                    </div>
                    <div class="divider"></div>

                     <div class="my-3">
                       
                            <input type="hidden" id="quantity" class="form-control" value="1" min="1" style="width: 80px;">
                      
                        
                        <div class="action-buttons d-flex">
                            <button class="btn btn-add-to-cart flex-grow-1 me-2" id="addToCartBtn" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Add to basket
                            </button>
                            <button class="btn btn-buy-now flex-grow-1 ms-2" id="buyNowBtn" data-product-id="{{ $product->id }}">
                                BUY NOW
                            </button>
                        </div>
                    </div>

                   
 <div id="cartMessage" class="mt-2"></div>
                    <div class="product-info mb-2">
                        <div class="info-row mb-2">
                            <span class="info-label">SKU:</span>
                            <span class="info-value" id="productSku">{{ $product->product_code }}</span>
                        </div>
                        <?php  

                                     $getProductInfoCount = \App\Models\OrderDetail::where('product_id',$product->id)
                                     ->whereDate('created_at', '>=', \Carbon\Carbon::now()->subDays(2))
                                     ->sum('quantity');

                                    ?>
                                    <div class="stock-info mb-4">
                        <i class="fas fa-fire text-danger me-2"></i>
                        <span class="stock-text">{{$getProductInfoCount}} Sold in last 48 hour</span>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <div class="categories mb-3">
                        <span class="info-label">Categories:</span>
                        @if($product->category)
                            <span class="info-value">{{ $product->category->name }}</span>
                        @endif
                        @if($product->subcategory)
                            , <span class="info-value">{{ $product->subcategory->name }}</span>
                        @endif
                    </div>

                    <div class="product-description">
                        {!! $product->description !!}
                    </div>

                     @if($product->variants->isNotEmpty())
                        <div class="row mb-3 align-items-center">
                            <div class="col-auto label-text">Available Color :</div>
                            <div class="col-auto" id="color-selector">
                                @foreach($product->variants as $variant)
                                    <span class="color-circle"
                                          style="background-color: {{ $variant->color->code }};"
                                          data-variant-id="{{ $variant->id }}"
                                          data-color-id="{{ $variant->color->id }}"
                                          data-main-image="{{ $front_ins_url . 'public/uploads/' . ($variant->main_image ?? $product->main_image[0]) }}"
                                          data-additional-price="{{ $variant->additional_price ?? 0 }}"
                                          data-variant-sku="{{ $variant->variant_sku ?? $product->product_code }}"
                                          data-sizes='{{ json_encode($variant->detailed_sizes) }}'></span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="row align-items-center" id="size-section" style="display: none;">
                        <div class="col-auto label-text">Available Size :</div>
                        <div class="col-auto sizes" id="size-selector">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="you-might-need mb-5 pb-lg-5">
    <div class="d-flex justify-content-between align-items-center mb-4 px-md-0">
        <h2 class="section-title">You might also like these products</h2>
    </div>
    <div class="row g-4">
        @forelse($relatedProducts as $related)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="product-card-need position-relative">
                <div class="card-bg-light w-100 position-absolute"></div>
                <div class="product-image d-flex justify-content-center">
                    <img src="{{ $front_ins_url . 'public/uploads/' . ($related->main_image[0] ?? '') }}" alt="{{ $related->name }}" class="img-fluid">
                </div>
                <div class="product-card">
                    <h6 class="product-name">{{ $related->name }}</h6>
                    <p class="product-price">
                        @if($related->discount_price)
                            &#2547; {{ number_format($related->discount_price, 2) }}
                            <del class="text-muted">&#2547; {{ number_format($related->base_price, 2) }}</del>
                        @else
                            &#2547; {{ number_format($related->base_price, 2) }}
                        @endif
                    </p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('product.show', $related->slug) }}" class="add-btn">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p>No related products found.</p>
        @endforelse
    </div>
</section>
@endsection

@section('script')
<script>
    // Global variable to store base price for calculations
    const baseProductPrice = {{ $product->discount_price ?? $product->base_price }};
    const originalBasePrice = {{ $product->base_price }}; // The non-discounted price
    const hasDiscount = {{ $product->discount_price ? 'true' : 'false' }};
    const takaIconHtml = `<img src="{{ asset('public/front/assets/img/taka-icon.png') }}" alt="Taka">`;

    function changeImage(element, newImageSrc) {
        document.getElementById('mainImage').src = newImageSrc;
        document.querySelectorAll('.thumbnail-container .single-img').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const colorSelector = document.getElementById('color-selector');
        const sizeSection = document.getElementById('size-section');
        const sizeSelector = document.getElementById('size-selector');
        const mainImage = document.getElementById('mainImage');
        const productPriceEl = document.getElementById('productPrice');
        const productSkuEl = document.getElementById('productSku');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const buyNowBtn = document.getElementById('buyNowBtn');

        // Function to update the displayed price
        function updatePrice(sizePrice = 0) {
            let finalPrice;
            // If a specific price is set for the size, use it. Otherwise, use the product's base price.
            if (sizePrice > 0) {
                finalPrice = sizePrice;
            } else {
                finalPrice = baseProductPrice;
            }

            let priceHtml = `${takaIconHtml} ${Number(finalPrice).toFixed(2)}`;
            
            // If the main product had a discount, and we are not using a size-specific price, show the original price
            if (hasDiscount && sizePrice <= 0) {
                 priceHtml += ` <span class="original-price text-decoration-line-through text-muted fs-5 ms-2">${Number(originalBasePrice).toFixed(2)}</span>`;
            }

            productPriceEl.innerHTML = priceHtml;
        }

        if (colorSelector) {
            const colors = colorSelector.querySelectorAll('.color-circle');
            
            colors.forEach(color => {
                color.addEventListener('click', function() {
                    colors.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    
                    const newImage = this.dataset.mainImage;
                    const newSku = this.dataset.variantSku;
                    const sizes = JSON.parse(this.dataset.sizes);
                    
                    mainImage.src = newImage;
                    productSkuEl.textContent = newSku;
                    
                    sizeSelector.innerHTML = '';
                    if (sizes.length > 0) {
                        sizes.forEach(size => {
                            const sizeSpan = document.createElement('span');
                            sizeSpan.classList.add('size-option');
                            sizeSpan.textContent = size.name;
                            sizeSpan.dataset.sizeId = size.id;
                            // **CRITICAL FIX**: Add the price to the size element
                            sizeSpan.dataset.price = size.price || 0;
                            sizeSelector.appendChild(sizeSpan);
                        });
                        sizeSection.style.display = 'flex';
                        // Reset price to default for the variant when color changes
                        updatePrice(); 
                    } else {
                        sizeSection.style.display = 'none';
                        updatePrice();
                    }
                });
            });
        }
        
        // **NEW**: Event listener for when a size is clicked
        sizeSelector.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('size-option')) {
                this.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
                e.target.classList.add('active');

                // Get the price from the selected size's data attribute and update the display
                const sizePrice = parseFloat(e.target.dataset.price) || 0;
                updatePrice(sizePrice);
            }
        });

        // --- ADD TO CART & BUY NOW LOGIC ---
        function handleCartAction(isBuyNow = false) {
            const selectedColor = colorSelector ? colorSelector.querySelector('.color-circle.active') : null;
            const selectedSize = sizeSelector ? sizeSelector.querySelector('.size-option.active') : null;
            
            if (colorSelector && !selectedColor) {
                toastr.error('Please select a color.'); return;
            }
            if (sizeSection.style.display !== 'none' && !selectedSize) {
                toastr.error('Please select a size.'); return;
            }

            const button = isBuyNow ? buyNowBtn : addToCartBtn;
            button.disabled = true;
            button.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Processing...`;

            const data = {
                product_id: button.dataset.productId,
                variant_id: selectedColor ? selectedColor.dataset.variantId : null,
                color_id: selectedColor ? selectedColor.dataset.colorId : null,
                size_id: selectedSize ? selectedSize.dataset.sizeId : null,
                quantity: document.getElementById('quantity').value
            };

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    updateCartCounter();
                    if (isBuyNow) {
                        window.location.href = '{{ route("cart.show") }}';
                    } else {
                        toastr.success(result.message);
                    }
                } else {
                    toastr.error(result.message || 'Could not add product to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An unexpected error occurred.');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = isBuyNow ? 'BUY NOW' : `<i class="fas fa-shopping-cart me-2"></i> Add to basket`;
            });
        }

        addToCartBtn.addEventListener('click', () => handleCartAction(false));
        buyNowBtn.addEventListener('click', () => handleCartAction(true));
    });
</script>
@endsection