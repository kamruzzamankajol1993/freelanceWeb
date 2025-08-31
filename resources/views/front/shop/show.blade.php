@extends('front.master.master')

@section('title', 'All Products')

@section('body')
 <!-- Hero Section -->
<section class="page-hero-section px-md-0 px-3">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="page-hero-title">Our Shop</h2>
                <div class="page-hero-nav-links bg-white rounded">
                    <a href="{{ route('home.index') }}">Home</a> - <span class="fw-bold">All Products</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- all products -->
<section class="you-might-need mb-5 pb-lg-5">
    <div class="d-flex justify-content-between align-items-center mb-4 px-md-0">
        <h2 class="section-title">All Products</h2>
    </div>
    {{-- This div will be populated with products --}}
    <div class="row g-4" id="product-grid">
        {{-- We reuse the same partial view for the product grid --}}
        @include('front.partials._product_grid', ['products' => $products])
    </div>

    {{-- Loading spinner, initially hidden --}}
    <div class="text-center mt-4" id="loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</section>
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
                            
                            <div class="mb-3">
                                <h6 class="fw-bold">Quantity:</h6>
                                <input type="number" id="modal-quantity" class="form-control" value="1" min="1" style="width: 100px;">
                            </div>
                            
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
$(document).ready(function() {
    let page = 2;
    let hasMore = true;
    let isLoading = false;

    $(window).scroll(function() {
        // Define the product grid element
        let productGrid = $('#product-grid');
        if (productGrid.length === 0) return; // Exit if the grid isn't on the page

        // Calculate the position of the bottom of the product grid
        let gridBottom = productGrid.offset().top + productGrid.outerHeight();

        // **MODIFIED CONDITION:** Check if the user's viewport has reached the bottom of the product grid
        if ($(window).scrollTop() + $(window).height() >= gridBottom - 200 && hasMore && !isLoading) {
            isLoading = true;
            $('#loading').show();

            $.ajax({
                url: '{{ route("shop.show") }}?page=' + page,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#loading').hide();
                    if (response.html.trim() == '') {
                        hasMore = false;
                        return;
                    }
                    $('#product-grid').append(response.html);
                    page++;
                    isLoading = false;
                },
                error: function() {
                    $('#loading').hide();
                    hasMore = false;
                    isLoading = false;
                }
            });
        }
    });
});
</script>
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