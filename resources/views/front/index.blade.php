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
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="product-item">
              <img src="assets/img/product.png" alt="T-Shirt" class="img-fluid">
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
            <div class="see-all-item">
              <div class="see-all-content">
                <div class="see-all-icon-rounded">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </div>
                <span>See All</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Second Section - You Might Need -->

    </div>

    <!-- you might-need -->
   


    <section class="you-might-need">
      <div class="d-flex justify-content-between align-items-center mb-4 px-md-0 px-3">
        <h2 class="section-title">You might need</h2>
        <a href="product.html" class="see-more-link">See more <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <div class="row g-4" id="products-grid">
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-product-id="1" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-product-id="1" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="product-card-need position-relative">
            <a href="product-details.html">
              <div class="position-relative">
                <div class="card-bg-light w-100 position-absolute"> </div>
                <div class="product-image d-flex justify-content-center">
                  <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                </div>
                <div class="product-card">
                  <h6 class="product-name">OT Run Men's T Shirt</h6>
                  <p class="product-price">৳ 650.00</p>

                </div>

              </div>
            </a>
            <div class="d-flex add-to-cart-parent justify-content-center">
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- product details -->
    <div class="container-fluid">
      <div class="p-md-5 product-details-area rounded">
        <!-- slider -->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
              aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
              aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
              aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row g-4">
                <!-- Left Section - Product Images -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-image-section">
                    <!-- Discount Badge -->
                    <div class="discount-badge">
                      <span class="discount-percent">70%</span>
                      <span class="discount-text-details">Discount</span>
                    </div>

                    <!-- Main Product Image -->
                    <div class="main-image-container rounded">
                      <img src="assets/img/product-full.png" alt="Naviforce Watch" class="main-product-image"
                        id="mainImage">
                    </div>

                    <!-- Thumbnail Images -->
                    <div class="thumbnail-container mt-3">
                      <div class="row g-2">
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded active"
                            onclick="changeImage(this, 'assets/img/product-full.png')">
                            <img src="assets/img/watch.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/product-2.png')">
                            <img src="assets/img/headphone.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-4.png')">
                            <img src="assets/img/details-4.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-3.png')">
                            <img src="assets/img/details-3.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>


                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Section - Product Details -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-details-section">
                    <!-- Countdown Timer -->
                    <div class="countdown-timer mb-3">
                      <img src="assets/img/clock.png" alt="">
                      <span id="countdown" class="countdown-text">10:20:15:56</span>
                    </div>

                    <!-- Product Title -->
                    <h2 class="product-title mb-3">Naviforce NF9056 Men Watch</h2>

                    <!-- Rating -->
                    <div class="rating-section mb-3">
                      <div class="stars">

                        <i class="fas fa-star-half-alt text-warning"></i>
                      </div>
                      <p class="rating-text ms-2 mb-0">4.5 Rating <span>(120 Review)</span></p>
                    </div>

                    <!-- Price -->
                    <div class="price-section mb-4">
                      <span class="current-price"><img src="assets/img/taka-icon.png" alt=""> 530.00</span>
                    </div>
                    <div class="divider"></div>

                    <!-- Action Buttons -->
                    <div class="action-buttons my-4">
                      <button class="btn btn-add-to-cart me-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Add to basket
                      </button>
                      <button class="btn btn-buy-now">
                        BUY NOW
                      </button>
                    </div>



                    <!-- Product Info -->
                    <div class="product-info mb-4">
                      <div class="info-row mb-2">
                        <span class="info-label">SKU:</span>
                        <span class="info-value">NF9056</span>
                      </div>
                      <div class="stock-info mb-4">
                        <i class="fas fa-fire text-danger me-2"></i>
                        <span class="stock-text">108 Sold in last 48 hour</span>
                      </div>
                      <div></div>
                    </div>
                    <div class="divider"></div>
                    <div class="categories mb-4">
                      <span class="info-label">Categories:</span>
                      <span class="info-value">mechanical, automatic, quartz</span>
                    </div>
                    <!-- Product Description -->
                    <div class="product-description">
                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Mechanical Watches:</b> These watches are powered by a mainspring
                          that
                          needs to be wound manually.
                          The spring's energy is transferred through gears to a regulated escapement mechanism, which
                          controls
                          the release of energy. The mechanism responds to the gears to move the hands forward at a
                          consistent
                          pace.</p>
                      </div>

                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"> <b>Automatic Watches:</b> A type of mechanical watch that winds
                          itself
                          using the movement of the
                          wearer's wrist. They typically have a rotor that swings with movement and winds the mainspring
                          automatically.</p>
                      </div>

                      <div class="description-item">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Quartz Watches:</b> These watches use a quartz crystal
                          oscillator,
                          which vibrates at a very
                          precise frequency when an electric current is applied. This vibration is used to regulate the
                          timekeeping mechanism, resulting in highly accurate timekeeping.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row g-4">
                <!-- Left Section - Product Images -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-image-section">
                    <!-- Discount Badge -->
                    <div class="discount-badge">
                      <span class="discount-percent">70%</span>
                      <span class="discount-text-details">Discount</span>
                    </div>

                    <!-- Main Product Image -->
                    <div class="main-image-container rounded">
                      <img src="assets/img/product-full.png" alt="Naviforce Watch" class="main-product-image"
                        id="mainImage">
                    </div>

                    <!-- Thumbnail Images -->
                    <div class="thumbnail-container mt-3">
                      <div class="row g-2">
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded active"
                            onclick="changeImage(this, 'assets/img/product-full.png')">
                            <img src="assets/img/watch.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/product-2.png')">
                            <img src="assets/img/headphone.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-4.png')">
                            <img src="assets/img/details-4.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-3.png')">
                            <img src="assets/img/details-3.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>


                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Section - Product Details -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-details-section">
                    <!-- Countdown Timer -->
                    <div class="countdown-timer mb-3">
                      <img src="assets/img/clock.png" alt="">
                      <span id="countdown" class="countdown-text">10:20:15:56</span>
                    </div>

                    <!-- Product Title -->
                    <h2 class="product-title mb-3">Naviforce NF9056 Men Watch</h2>

                    <!-- Rating -->
                    <div class="rating-section mb-3">
                      <div class="stars">

                        <i class="fas fa-star-half-alt text-warning"></i>
                      </div>
                      <p class="rating-text ms-2 mb-0">4.5 Rating <span>(120 Review)</span></p>
                    </div>

                    <!-- Price -->
                    <div class="price-section mb-4">
                      <span class="current-price"><img src="assets/img/taka-icon.png" alt=""> 530.00</span>
                    </div>
                    <div class="divider"></div>

                    <!-- Action Buttons -->
                    <div class="action-buttons my-4">
                      <button class="btn btn-add-to-cart me-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Add to basket
                      </button>
                      <button class="btn btn-buy-now">
                        BUY NOW
                      </button>
                    </div>



                    <!-- Product Info -->
                    <div class="product-info mb-4">
                      <div class="info-row mb-2">
                        <span class="info-label">SKU:</span>
                        <span class="info-value">NF9056</span>
                      </div>
                      <div class="stock-info mb-4">
                        <i class="fas fa-fire text-danger me-2"></i>
                        <span class="stock-text">108 Sold in last 48 hour</span>
                      </div>
                      <div></div>
                    </div>
                    <div class="divider"></div>
                    <div class="categories mb-4">
                      <span class="info-label">Categories:</span>
                      <span class="info-value">mechanical, automatic, quartz</span>
                    </div>
                    <!-- Product Description -->
                    <div class="product-description">
                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Mechanical Watches:</b> These watches are powered by a mainspring
                          that
                          needs to be wound manually.
                          The spring's energy is transferred through gears to a regulated escapement mechanism, which
                          controls
                          the release of energy. The mechanism responds to the gears to move the hands forward at a
                          consistent
                          pace.</p>
                      </div>

                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"> <b>Automatic Watches:</b> A type of mechanical watch that winds
                          itself
                          using the movement of the
                          wearer's wrist. They typically have a rotor that swings with movement and winds the mainspring
                          automatically.</p>
                      </div>

                      <div class="description-item">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Quartz Watches:</b> These watches use a quartz crystal
                          oscillator,
                          which vibrates at a very
                          precise frequency when an electric current is applied. This vibration is used to regulate the
                          timekeeping mechanism, resulting in highly accurate timekeeping.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row g-4">
                <!-- Left Section - Product Images -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-image-section">
                    <!-- Discount Badge -->
                    <div class="discount-badge">
                      <span class="discount-percent">70%</span>
                      <span class="discount-text-details">Discount</span>
                    </div>

                    <!-- Main Product Image -->
                    <div class="main-image-container rounded">
                      <img src="assets/img/product-full.png" alt="Naviforce Watch" class="main-product-image"
                        id="mainImage">
                    </div>

                    <!-- Thumbnail Images -->
                    <div class="thumbnail-container mt-3">
                      <div class="row g-2">
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded active"
                            onclick="changeImage(this, 'assets/img/product-full.png')">
                            <img src="assets/img/watch.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/product-2.png')">
                            <img src="assets/img/headphone.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-4.png')">
                            <img src="assets/img/details-4.png" alt="Watch Front" class="thumbnail-image">
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="single-img p-3 d-flex justify-content-center rounded"
                            onclick="changeImage(this, 'assets/img/details-3.png')">
                            <img src="assets/img/details-3.png" alt="Headphones" class="thumbnail-image">
                          </div>
                        </div>


                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Section - Product Details -->
                <div class="col-lg-6 col-md-12">
                  <div class="product-details-section">
                    <!-- Countdown Timer -->
                    <div class="countdown-timer mb-3">
                      <img src="assets/img/clock.png" alt="">
                      <span id="countdown" class="countdown-text">10:20:15:56</span>
                    </div>

                    <!-- Product Title -->
                    <h2 class="product-title mb-3">Naviforce NF9056 Men Watch</h2>

                    <!-- Rating -->
                    <div class="rating-section mb-3">
                      <div class="stars">

                        <i class="fas fa-star-half-alt text-warning"></i>
                      </div>
                      <p class="rating-text ms-2 mb-0">4.5 Rating <span>(120 Review)</span></p>
                    </div>

                    <!-- Price -->
                    <div class="price-section mb-4">
                      <span class="current-price"><img src="assets/img/taka-icon.png" alt=""> 530.00</span>
                    </div>
                    <div class="divider"></div>

                    <!-- Action Buttons -->
                    <div class="action-buttons my-4">
                      <button class="btn btn-add-to-cart me-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Add to basket
                      </button>
                      <button class="btn btn-buy-now">
                        BUY NOW
                      </button>
                    </div>



                    <!-- Product Info -->
                    <div class="product-info mb-4">
                      <div class="info-row mb-2">
                        <span class="info-label">SKU:</span>
                        <span class="info-value">NF9056</span>
                      </div>
                      <div class="stock-info mb-4">
                        <i class="fas fa-fire text-danger me-2"></i>
                        <span class="stock-text">108 Sold in last 48 hour</span>
                      </div>
                      <div></div>
                    </div>
                    <div class="divider"></div>
                    <div class="categories mb-4">
                      <span class="info-label">Categories:</span>
                      <span class="info-value">mechanical, automatic, quartz</span>
                    </div>
                    <!-- Product Description -->
                    <div class="product-description">
                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Mechanical Watches:</b> These watches are powered by a mainspring
                          that
                          needs to be wound manually.
                          The spring's energy is transferred through gears to a regulated escapement mechanism, which
                          controls
                          the release of energy. The mechanism responds to the gears to move the hands forward at a
                          consistent
                          pace.</p>
                      </div>

                      <div class="description-item mb-4">
                        <h6 class="description-title"></h6>
                        <p class="description-text"> <b>Automatic Watches:</b> A type of mechanical watch that winds
                          itself
                          using the movement of the
                          wearer's wrist. They typically have a rotor that swings with movement and winds the mainspring
                          automatically.</p>
                      </div>

                      <div class="description-item">
                        <h6 class="description-title"></h6>
                        <p class="description-text"><b>Quartz Watches:</b> These watches use a quartz crystal
                          oscillator,
                          which vibrates at a very
                          precise frequency when an electric current is applied. This vibration is used to regulate the
                          timekeeping mechanism, resulting in highly accurate timekeeping.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- slider end -->

      </div>
    </div>

    <!-- discount product -->

    <!-- discount product -->
    <div class="mt-md-5 pt-5 px-3 px-md-0">
      <div class="row g-4">
        <!-- Card 1 - Watch -->
        <div class="col-lg-3 col-6 col-md-6">
          <div class="card discount-card card-1">
            <div class="card-body p-3">
              <div class="card-content">
                <span class="save-badge">Save</span>
                <p class="mb-0 discount-amount"> <span>৳</span> 500</>
                </p>
                <p class="discount-text">Enjoy discount all types of watch item.</p>
              </div>
            </div>
            <img src="assets/img/discount.png" alt="Watch" class="discount-product-image">
          </div>
        </div>

        <!-- Card 2 - Headphones -->
        <div class="col-lg-3 col-6 col-md-6">
          <div class="card discount-card card-2">
            <div class="card-body p-3">
              <div class="card-content">
                <span class="save-badge">Save</span>
                <p class="discount-amount mb-0"> <span>৳</span> 70</p>
                <p class="discount-text">Enjoy discount all types of gadgets item.</p>
              </div>
            </div>
            <img src="assets/img/discount.png" alt="Headphones" class="discount-product-image">
          </div>
        </div>

        <!-- Card 3 - Shoes -->
        <div class="col-lg-3 col-6 col-md-6">
          <div class="card discount-card card-3">
            <div class="card-body p-3">
              <div class="card-content">
                <span class="save-badge">Save</span>
                <p class="discount-amount mb-0"> <span>৳</span> 130</p>
                <p class="discount-text">Enjoy discount all types of shoes item.</p>
              </div>
            </div>
            <img src="assets/img/discount.png" alt="Shoes" class="discount-product-image">
          </div>
        </div>

        <!-- Card 4 - Frame -->
        <div class="col-lg-3 col-6 col-md-6">
          <div class="card discount-card card-4">
            <div class="card-body p-3">
              <div class="card-content">
                <span class="save-badge">Save</span>
                <p class="discount-amount mb-0"> <span>৳</span> 40</p>
                <p class="discount-text">Enjoy discount all types of premium unique frames item.</p>
              </div>
            </div>
            <img src="assets/img/discount.png" alt="Frame" class="discount-product-image">
          </div>
        </div>
      </div>
    </div>


    <!-- weekly product -->
    <section class="weekly px-md-0 px-3">
      <ul class="nav nav-pills custom-nav-pills mb-md-5 pb-md-5" id="productTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="men-tshirt-tab" data-bs-toggle="pill" data-bs-target="#men-tshirt"
            type="button" role="tab">Men's T Shirt</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="gadgets-tab" data-bs-toggle="pill" data-bs-target="#gadgets" type="button"
            role="tab">Gadgets</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="leather-tab" data-bs-toggle="pill" data-bs-target="#leather" type="button"
            role="tab">Leather Item's</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="watch-tab" data-bs-toggle="pill" data-bs-target="#watch" type="button"
            role="tab">Men's Watch</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="frame-tab" data-bs-toggle="pill" data-bs-target="#frame" type="button"
            role="tab">Wall Frame's</button>
        </li>
      </ul>

      <!-- Example tab content -->
      <div class="tab-content" id="productTabContent">
        <div class="tab-pane fade show active" id="men-tshirt" role="tabpanel">
          <!-- ment's t-shirt -->
          <div class="you-might-need">
            <div class="row g-4">
              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="gadgets" role="tabpanel">
          <!-- gadgets -->
          <div class="you-might-need">
            <div class="row">
              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="product-card-need position-relative">
                  <a href="product-details.html">
                    <div class="position-relative">
                      <div class="card-bg-light w-100 position-absolute"> </div>
                      <div class="product-image d-flex justify-content-center">
                        <img src="assets/img/product-2.png" alt="OT Run Men's T Shirt" class="img-fluid">
                      </div>
                      <div class="product-card">
                        <h6 class="product-name">OT Run Men's T Shirt</h6>
                        <p class="product-price">৳ 650.00</p>

                      </div>

                    </div>
                  </a>
                  <div class="d-flex add-to-cart-parent justify-content-center">
                    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="leather" role="tabpanel">...</div>
        <div class="tab-pane fade" id="watch" role="tabpanel">...</div>
        <div class="tab-pane fade" id="frame" role="tabpanel">...</div>
      </div>

    </section>


    <!-- fast delivery -->
    <div class="section px-md-0 px-3">
      <div class="delivery-section ">
        <!-- Logo -->
        <div class="logo-2">
          <img src="assets/img/logo-2.png" alt="Premier Web Retail Logo">
        </div>

        <!-- Main Content -->
        <div class="main-content">
          <div class="hero-text">
            <h2>Stay Home and Get All Your Essentials Form Our Market!</h2>
          </div>
        </div>

        <!-- Delivery Man -->
        <div class="delivery-man">
          <img src="assets/img/Delivery Boy 1.png" alt="Delivery Man">
        </div>
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
            <img src="assets/img/cycle-02 1.png" alt="Delivery cyclist" class="cyclist-image card-img">
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
            <img src="assets/img/gift.png" alt="Delivery cyclist" class="card-img coupon-img">
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
                    <img src="assets/img/7.png" alt=""></div>
                  <h2 class="customer-service-title">Emergency Service Open</h2>
                  <!-- <a href="tel:+8801611416065" class="customer-service-phone">+8801843369439</a> -->
                  <p class="mb-0 customer-service-phone">+8801600000000</p>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12">
                <div class="customer-service-image-wrapper">
                  <div class="angel position-absolute d-lg-block d-none">
                    <img src="assets/img/angel.png" alt="">
                  </div>
                  <img src="assets/img/24.png" alt="Customer Service Representative" class="customer-service-image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
@endsection

@section('script')
@endsection