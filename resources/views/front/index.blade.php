@extends('front.master.master')

@section('title')
Home
@endsection

@section('body')


    <!-- Hero Slider -->
   @include('front.include.banner')

    <div>
      <!-- First Section - 7 Column Product Row -->
      <section class="product-showcase my-5">
        <div class="row g-3">

            @foreach($categoryListNew as $categoryListNews)
            <?php  

            $getProductInfo = \App\Models\Product::where('category_id',$categoryListNews->id)->orderBy('id','desc')->first();


?>
@if($getProductInfo)
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="{{ $front_ins_url . 'public/uploads/' . $getProductInfo->main_image[0] }}" alt="{{ $getProductInfo->name }}" class="img-fluid">
            </div>
          </div>
          @endif
          @endforeach
         
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="see-all-item">
              <div class="see-all-content">
                     <a href="{{ route('shop.show') }}" class="see-all-content">
                <div class="see-all-icon-rounded">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </div>
                <span>See All</span>
                     </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Second Section - You Might Need -->

    </div>

  
   


    <section class="you-might-need">
  <div class="d-flex justify-content-between align-items-center mb-4 px-md-0 px-3">
    <h2 class="section-title">You might need</h2>
    <a href="{{ route('shop.show') }}" class="see-more-link">See more <i class="fa-solid fa-arrow-right"></i></a>
  </div>
  <div class="row g-4" id="products-grid">

    {{-- Loop through the latest products --}}
    @foreach($latestProducts as $product)
    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
      <div class="product-card-need position-relative">
        <a href="{{ route('product.show', $product->slug) }}">
          <div class="position-relative">
            <div class="card-bg-light w-100 position-absolute"> </div>
            <div class="product-image d-flex justify-content-center">
              {{-- NOTE: Assuming images are in 'public/uploads/products/' and using the first main image --}}
              <img src="{{ $front_ins_url . 'public/uploads/' . $product->thumbnail_image[0] }}" alt="{{ $product->name }}" class="img-fluid">
            </div>
            <div class="product-card">
              <h6 class="product-name">{{ $product->name }}</h6>
              <p class="product-price">
                {{-- Check if there is a discount price --}}
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
          {{-- The button can trigger a quick view modal or add directly to cart --}}
          <button class="add-btn quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal" data-id="{{ $product->id }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
      </div>
    </div>
    @endforeach

  </div>
</section>
@if($offerProducts->isNotEmpty())
<div class="container-fluid">
    <div class="p-md-5 product-details-area rounded">
    
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($offerProducts as $offer)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($offerProducts as $offer)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4">
                        <div class="col-lg-6 col-md-12">
                            <div class="product-image-section">
                                @php
                                    $basePrice = $offer->product->base_price;
                                    $offerPrice = $offer->discount_price;
                                    if($basePrice > 0) {
                                        $discountPercent = round((($basePrice - $offerPrice) / $basePrice) * 100);
                                    } else {
                                        $discountPercent = 0;
                                    }
                                @endphp
                                <div class="discount-badge">
                                    <span class="discount-percent">{{ $discountPercent }}%</span>
                                    <span class="discount-text-details">Discount</span>
                                </div>

                                <div class="main-image-container rounded">
                                    <img src="{{ $front_ins_url . 'public/uploads/' . $offer->product->main_image[0] }}" alt="{{ $offer->product->name }}" class="main-product-image" id="mainImage_{{ $offer->id }}">
                                </div>

                                <div class="thumbnail-container mt-3">
                                    <div class="row g-2">
                                        @foreach($offer->product->thumbnail_image as $thumb)
                                        <div class="col-3">
                                            <div class="single-img p-3 d-flex justify-content-center rounded" onclick="changeImage(this, '{{ $front_ins_url . 'public/uploads/' . $thumb }}', 'mainImage_{{ $offer->id }}')">
                                                <img src="{{ $front_ins_url . 'public/uploads/'  . $thumb }}" alt="Thumbnail" class="thumbnail-image">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="product-details-section">
                                <div class="countdown-timer mb-3" data-end-date="{{ $offer->offer_end_date }}">
                                    <img src="{{ asset('public/front/assets/img/clock.png') }}" alt="clock">
                                    <span class="countdown-text">--:--:--:--</span>
                                </div>

                                <h2 class="product-title mb-3">{{ $offer->product->name }}</h2>

                                <!-- Rating -->
                    <div class="rating-section mb-3">
                      <div class="stars">

                        <i class="fas fa-star-half-alt text-warning"></i>
                      </div>
                      <p class="rating-text ms-2 mb-0">4.5 Rating <span>(120 Review)</span></p>
                    </div>

                                <div class="price-section mb-4">
                                    <span class="current-price"><img src="{{ asset('public/front/assets/img/taka-icon.png') }}" alt="taka"> {{ number_format($offer->discount_price, 2) }}</span>
                                    <del class="text-muted fs-5 ms-2">৳ {{ number_format($offer->product->base_price, 2) }}</del>
                                </div>
                                
                                <div class="divider"></div>

                                <div class="action-buttons my-4">
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-add-to-cart me-3">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        View Details
                                    </a>
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-buy-now">
                                        BUY NOW
                                    </a>
                                </div>

                                <div class="product-info mb-4">
                                    <div class="info-row mb-2">
                                        <span class="info-label">SKU:</span>
                                        <span class="info-value">{{ $offer->product->product_code }}</span>
                                    </div>

                                    <?php  

                                     $getProductInfoCount = \App\Models\OrderDetail::where('product_id',$offer->product->id)
                                     ->whereDate('created_at', '>=', \Carbon\Carbon::now()->subDays(2))
                                     ->sum('quantity');

                                    ?>
                                    <div class="stock-info mb-4">
                        <i class="fas fa-fire text-danger me-2"></i>
                        <span class="stock-text">{{$getProductInfoCount}} Sold in last 48 hour</span>
                      </div>
                                </div>
                                <div class="divider"></div>
                                <div class="categories mb-4">
                                    <span class="info-label">Category:</span>
                                    <span class="info-value">{{ $offer->product->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="product-description">
                                    <div class="description-item mb-4">
                                       {{strip_tags($offer->product->description)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
      
    </div>
</div>
  @endif
    <!-- discount product -->

    <!-- discount product -->
     @if($discountedProducts->isNotEmpty())
    <div class="mt-md-5 pt-5 px-3 px-md-0">
   
    <div class="row g-4">
        @foreach($discountedProducts as $product)
            @php
                // Calculate the amount saved
                $savedAmount = $product->base_price - $product->discount_price;
            @endphp
            <div class="col-lg-3 col-6 col-md-6">
                <a href="{{ route('product.show', $product->slug) }}" style="text-decoration: none;">
                    {{-- The loop iteration sets the card color class (card-1, card-2, etc.) --}}


                    @if($loop->iteration == 1)

                    <div class="card discount-card card-1">
                      @elseif($loop->iteration == 2)

                      <div class="card discount-card card-2">

                      @elseif($loop->iteration == 3)

                      <div class="card discount-card card-3">

                      @elseif($loop->iteration == 4)
<div class="card discount-card card-4">
                      @endif


                        <div class="card-body p-3">
                            <div class="card-content">
                                <span class="save-badge">Save</span>
                                <p class="mb-0 discount-amount">
                                    <span>৳</span> {{ number_format($savedAmount, 0) }}
                                </p>
                                <p class="discount-text">Enjoy Discount on {{ $product->category->name ?? 'selected item' }}.</p>
                            </div>
                        </div>
                        {{-- Using the product's main image --}}
                        <img src="{{ $front_ins_url . 'public/uploads/' . $product->thumbnail_image[0] }}" alt="{{ $product->name }}" class="discount-product-image">
                    </div>
                </a>
            </div>
        @endforeach
    </div>
   
</div>
 @endif

    <!-- weekly product -->
    <section class="weekly px-md-0 px-3">

      <div class="d-flex justify-content-between align-items-center mb-4 px-md-0 px-3">
    <h2 class="section-title">Weekly best selling item</h2>
    <a href="{{ route('shop.show') }}" class="see-more-link">See more <i class="fa-solid fa-arrow-right"></i></a>
  </div>

    @if($tabCategories->isNotEmpty())
    {{-- DYNAMIC TABS --}}
    <ul class="nav nav-pills custom-nav-pills mb-md-5 pb-md-5" id="productTab" role="tablist">
        @foreach($tabCategories as $category)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $category->slug }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $category->slug }}" type="button" role="tab">{{ $category->name }}</button>
        </li>
        @endforeach
    </ul>

    {{-- DYNAMIC TAB CONTENT --}}
    <div class="tab-content" id="productTabContent">
        @foreach($tabCategories as $category)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $category->slug }}" role="tabpanel">
            <div class="you-might-need">
                <div class="row g-4">
                    {{-- Loop through products for the current category tab --}}
                    @forelse($category->products as $product)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="product-card-need position-relative">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <div class="position-relative">
                                    <div class="card-bg-light w-100 position-absolute"> </div>
                                    <div class="product-image d-flex justify-content-center">
                                        <img src="{{ $front_ins_url . 'public/uploads/' . $product->main_image[0] }}" alt="{{ $product->name }}" class="img-fluid">
                                    </div>
                                    <div class="product-card">
                                        {{-- Use Str::limit to shorten the product name --}}
                                        <h6 class="product-name">{{ $product->name }}</h6>
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
                    @empty
                    <div class="col-12">
                        <p class="text-center">No products found in this category.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</section>


    <!-- fast delivery -->
    <div class="section px-md-0 px-3">
      <div class="delivery-section ">
        <!-- Logo -->
        <div class="logo-2">
          <img src="{{$front_ins_url}}{{$front_black_logo_name}}" alt="Premier Web Retail Logo">
        </div>

        <!-- Main Content -->
        <div class="main-content">
          <div class="hero-text">
            <h2>Stay Home and Get All Your Essentials Form Our Market!</h2>
          </div>
        </div>

        <!-- Delivery Man -->
        @if(isset($offerBanners['1st']))
        <div class="delivery-man">
          <img src="{{ $front_ins_url . $offerBanners['1st']->image }}" alt="Delivery Man">
        </div>
        @endif
      </div>
    </div>

    <!-- delivery and coupon -->

    <section class="delivery-coupon py-lg-0 py-5 px-md-0 px-3">
      <div class="row g-4">
        <div class="col-lg-6 col-12">
          <div class="delivery-card">
            <div class="content-wrapper">
              <div class="delivery-badge card-badge">
                Free delivery
              </div>
              <h4 class="main-heading">
                Get up to 50% off <br>
                Delivery by 10:15am <br>
                Fast and free
              </h4>

            </div>
              @if(isset($offerBanners['2nd']))
            <img src="{{ $front_ins_url . $offerBanners['2nd']->image }}" alt="Delivery cyclist" class="cyclist-image card-img">
            @endif
          </div>
        </div>
        <div class="col-lg-6 col-12">
          <div class="delivery-card coupon-card">
            <div class="content-wrapper">
              <div class="coupon-badge card-badge">
                Free delivery
              </div>
              <h4 class="main-heading coupon-heading">
                Get up to 50% off <br>
                Delivery by 10:15am <br>
                Fast and free
              </h4>

            </div>
            @if(isset($offerBanners['3rd']))
            <img src="{{ $front_ins_url . $offerBanners['3rd']->image }}" alt="Delivery cyclist" class="card-img coupon-img">
            @endif
          </div>
        </div>
      </div>

    </section>

    <!-- customer service -->
    <div class="px-md-0 px-3">
      <section class="customer-service-section mt-md-5 mb-5">
        <div class="customer-service-container">
          <div class="customer-service-background"></div>
          <div class="wrapper pb-0">
            <div class="row align-items-center">
              <div class="col-lg-6 col-md-6 col-12">
                <div class="customer-service-content">
                  <div class="support-time d-lg-block d-none">
                    <img src="{{asset('/')}}public/front/assets/img/7.png" alt=""></div>
                  <h2 class="customer-service-title">Emergency Service Open</h2>
                  <!-- <a href="tel:+8801611416065" class="customer-service-phone">+8801843369439</a> -->
                  <p class="mb-0 customer-service-phone">+8801600000000</p>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <div class="customer-service-image-wrapper">
                  <div class="angel position-absolute d-lg-block d-none">
                    <img src="{{asset('/')}}public/front/assets/img/angel.png" alt="">
                  </div>
                   @if(isset($offerBanners['4th']))
                  <img src="{{ $front_ins_url . $offerBanners['4th']->image }}" alt="Customer Service Representative" class="customer-service-image">
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
     <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewModalLabel">Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <img id="modal-product-image" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 400px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modal-product-name"></h3>
                            <p id="modal-product-price" class="fs-4 fw-bold"></p>
                            
                            <div id="modal-variants-container">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Color:</h6>
                                    <div id="modal-color-options" class="d-flex flex-wrap gap-2">
                                        </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Size:</h6>
                                    <div id="modal-size-options" class="d-flex flex-wrap gap-2">
                                        </div>
                                </div>
                            </div>
                            
                            
                                <input type="hidden" id="modal-quantity" class="form-control" value="1" min="1" style="width: 100px;">
                            
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-add-to-cart-btn">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    // Global variable to store product data for the modal
    let modalProductData = {};

    // Function to change the main image when a thumbnail is clicked
    function changeImage(element, newImageSrc, mainImageId) {
        // Update the main image source
        document.getElementById(mainImageId).src = newImageSrc;
        
        // Handle the 'active' class on thumbnails
        const parentContainer = element.closest('.thumbnail-container');
        parentContainer.querySelectorAll('.single-img').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    // Function to initialize all countdown timers on the page
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown-timer');
        
        countdownElements.forEach(function(element) {
            const endDate = new Date(element.dataset.endDate).getTime();
            const countdownText = element.querySelector('.countdown-text');

            const interval = setInterval(function() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    clearInterval(interval);
                    countdownText.innerHTML = "OFFER EXPIRED";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownText.innerHTML = `${days}d : ${hours}h : ${minutes}m : ${seconds}s`;
            }, 1000);
        });
    });

    // ===================================
    // QUICK VIEW MODAL SCRIPT START
    // ===================================
    $(document).ready(function() {
        // 1. Handle Quick View button click
        $('.quick-view-btn').on('click', function() {
            const productId = $(this).data('id');
            const url = `{{ url('/product-quick-view') }}/${productId}`;

            // Reset modal state
            $('#modal-product-name').text('Loading...');
            $('#modal-product-price').empty();
            $('#modal-color-options').empty();
            $('#modal-size-options').empty();
            $('#modal-product-image').attr('src', '{{ asset("placeholder.jpg") }}'); // Optional: use a placeholder
            
            // AJAX request to get product data
            $.ajax({
                url: url,
                type: 'GET',
                success: function(product) {
                    modalProductData = product; // Store data globally
                    populateModal(product);
                },
                error: function() {
                    $('#modal-product-name').text('Error loading product.');
                }
            });
        });

        // 2. Function to populate modal with product data
        function populateModal(product) {
            const baseUrl = '{{ $front_ins_url }}public/uploads/';
            
            // Populate basic info
            $('#modal-product-name').text(product.name);
            let priceHtml = '';
            if (product.discount_price) {
                priceHtml = `৳ ${Number(product.discount_price).toFixed(2)} <del class="text-muted ms-2">৳ ${Number(product.base_price).toFixed(2)}</del>`;
            } else {
                priceHtml = `৳ ${Number(product.base_price).toFixed(2)}`;
            }
            $('#modal-product-price').html(priceHtml);
            $('#modal-product-image').attr('src', baseUrl + product.main_image[0]);
            $('#modal-add-to-cart-btn').data('product-id', product.id);

            // Handle variants
            if (product.variants && product.variants.length > 0) {
                $('#modal-variants-container').show();
                let colorOptionsHtml = '';
                product.variants.forEach((variant, index) => {
                    colorOptionsHtml += `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="color_option" id="color_${variant.color.id}" value="${variant.color.id}" ${index === 0 ? 'checked' : ''}>
                            <label class="form-check-label" for="color_${variant.color.id}">${variant.color.name}</label>
                        </div>
                    `;
                });
                $('#modal-color-options').html(colorOptionsHtml);
                
                // Trigger change to populate initial sizes
                $('input[name="color_option"]:checked').trigger('change');

            } else {
                // No variants, hide selectors
                 $('#modal-variants-container').hide();
            }
        }

        // 3. Handle color selection change
        $(document).on('change', 'input[name="color_option"]', function() {
            const selectedColorId = $(this).val();
            const variant = modalProductData.variants.find(v => v.color_id == selectedColorId);

            $('#modal-size-options').empty();
            if (variant && variant.detailed_sizes && variant.detailed_sizes.length > 0) {
                let sizeOptionsHtml = '';
                variant.detailed_sizes.forEach((size, index) => {
                    sizeOptionsHtml += `
                       <div class="form-check">
                           <input class="form-check-input" type="radio" name="size_option" id="size_${size.id}" value="${size.id}" ${index === 0 ? 'checked' : ''}>
                           <label class="form-check-label" for="size_${size.id}">${size.name}</label>
                       </div>
                    `;
                });
                 $('#modal-size-options').html(sizeOptionsHtml);
            } else {
                 $('#modal-size-options').html('<p class="text-muted">No sizes available for this color.</p>');
            }
        });

        // 4. Handle "Add to Cart" button click inside the modal
        // 4. Handle "Add to Cart" button click inside the modal
$('#modal-add-to-cart-btn').on('click', function() {
    const productId = $(this).data('product-id');
    const quantity = $('#modal-quantity').val();

    // FIX: Define selectedColorRadio before using it
    const selectedColorRadio = $('input[name="color_option"]:checked'); 
    const selectedColorId = selectedColorRadio.val();
    const selectedVariantId = selectedColorRadio.data('variant-id');
    
    const selectedSizeId = $('input[name="size_option"]:checked').val();
    const addToCartUrl = '{{ route("cart.add") }}';
    
    // Basic validation
     if(quantity < 1){
                toastr.warning('Quantity must be at least 1.'); // <-- Changed
                return;
            }
            if(modalProductData.variants.length > 0 && !selectedColorId){
                toastr.warning('Please select a color.'); // <-- Changed
                return;
            }
            if(modalProductData.variants.length > 0 && !selectedSizeId){
                toastr.warning('Please select a size.'); // <-- Changed
                return;
            }

    // Prepare data for AJAX request
    const data = {
        _token: '{{ csrf_token() }}',
        product_id: productId,
        quantity: quantity,
        variant_id: selectedVariantId,
        color_id: selectedColorId,
        size_id: selectedSizeId
    };

    $.ajax({
        url: addToCartUrl,
        type: 'POST',
        data: data,
        success: function(response) {
            toastr.success('Product added to cart successfully!');  // Replace with a nicer notification if you have one
            $('#quickViewModal').modal('hide');
            updateCartCounter()
            // You might want to update a cart icon/counter here
        },
        error: function(xhr) {
            // Handle errors, e.g., show validation messages
              toastr.error('Error adding product to cart. Please try again.');
            console.log(xhr.responseText);
        }
    });
});
    });
    // ===================================
    // QUICK VIEW MODAL SCRIPT END
    // ===================================

</script>
@endsection