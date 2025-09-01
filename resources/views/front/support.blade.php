@extends('front.master.master')
@section('title')
Support
@endsection

@section('css')
 <style>
        :root {
            --custom-primary: #00B2E3;
            --custom-primary-darker: #0099c4;
            --custom-light-cyan: #E5F7FB;
            --custom-border: #EAEAEA;
        }
        
        /* Custom styles to match the provided design */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFFFFF;
        }

        .text-primary {
            color: var(--custom-primary) !important;
        }

        .btn-primary {
            background-color: var(--custom-primary);
            border-color: var(--custom-primary);
        }

        .btn-primary:hover {
            background-color: var(--custom-primary-darker);
            border-color: var(--custom-primary-darker);
        }

        .title-background-wrapper {
            background-color: var(--custom-light-cyan);
            padding: 3rem 0;
        }

        /* Search Bar styling */
        .search-wrapper .input-group {
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden; /* To make sure children conform to the border-radius */
        }
        .search-wrapper .form-control, 
        .search-wrapper .input-group-text {
            border: none;
        }
        .search-wrapper .form-control:focus {
            box-shadow: 0 0 0 2px var(--custom-primary);
            z-index: 3;
        }

        /* Support Cards styling */
        .support-card {
            border: 1px solid var(--custom-border);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, border-color 0.2s ease-in-out;
            border-radius: 0.5rem;
        }

        .support-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--custom-primary);
        }

        .card-title {
            font-weight: 600;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Contact Box styling */
        .contact-box {
            background-color: var(--custom-light-cyan);
            border-radius: 1rem;
        }

        .contact-box i {
            color: var(--custom-primary);
        }
        
        /* FAQ items styling */
        .faq-item {
            background-color: #ffffff;
            border: 1px solid var(--custom-border);
            border-radius: 0.5rem;
            padding: 1rem;
            font-weight: 500;
            color: #343a40;
            cursor: pointer;
            transition: border-color 0.2s ease-in-out;
        }

        .faq-item:hover {
            border-color: var(--custom-primary);
        }
        
        /* Accordion styling */
        .accordion {
            border: 1px solid var(--custom-border);
            border-radius: 0.5rem;
            overflow: hidden; /* Ensures the border radius is applied to child elements */
        }
        .accordion-item {
            border: none;
            border-bottom: 1px solid var(--custom-border);
        }
        .accordion-item:last-child {
            border-bottom: none;
        }
        .accordion-button {
            font-weight: 500;
            color: #343a40;
        }
        .accordion-button:not(.collapsed) {
            color: var(--custom-primary);
            background-color: var(--custom-light-cyan);
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 178, 227, 0.25);
            border-color: var(--custom-primary);
        }

        /* Custom Accordion Icons */
        .accordion-button::after {
            background-image: none; /* Remove default Bootstrap arrow */
            font-family: 'Font Awesome 5 Free';
            content: '\f067'; /* Unicode for fa-plus */
            font-weight: 900;
            color: var(--custom-primary);
            transition: transform 0.2s ease-in-out;
        }

        .accordion-button:not(.collapsed)::after {
            content: '\f068'; /* Unicode for fa-minus */
            transform: rotate(0); /* Ensure no rotation on the minus icon */
        }
    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" xintegrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('body')
<section class="">
      <div class="title-background-wrapper">
        <div class="container">
            <!-- Main Title Section -->
            <section class="text-center">
                <h1 class="display-5 fw-bold text-primary mb-3">Customer Care Hub</h1>
                <p class="d-inline-block bg-white px-4 py-2 rounded shadow-sm text-muted" style="color:#00B2E3 !important;font-weight:bold;">Welcome to our support gateway</p>
            </section>
        </div>
    </div>

    <div class="container my-5">
        <!-- Search Bar Section -->
        <section class="mb-5 py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-center mb-4 fw-semibold text-primary">How Can We Help You Today?</h2>
                    <div class="search-wrapper">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0" id="search-icon"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Ask Us Anything" aria-label="Ask Us Anything" aria-describedby="search-icon">
                            <button class="btn btn-primary px-4" type="button">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Support Categories Grid -->
        <section class="mb-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <!-- Getting Started -->
                <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-rocket display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Getting Started</h5>
                            <p class="card-text">New to our platform? Find guides and tutorials to get you up and running.</p>
                        </div>
                    </div>
                </div>
                <!-- Orders & Tracking -->
                <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-box-open display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Orders & Tracking</h5>
                            <p class="card-text">Track your shipment, view order history, and manage your purchases.</p>
                        </div>
                    </div>
                </div>
                <!-- Shipping & Delivery -->
                <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-truck display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Shipping & Delivery</h5>
                            <p class="card-text">Learn about shipping options, delivery times, and associated costs.</p>
                        </div>
                    </div>
                </div>
                 <!-- Payments & Billing -->
                <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="far fa-credit-card display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Payments & Billing</h5>
                            <p class="card-text">Manage your payment methods, view invoices, and get billing support.</p>
                        </div>
                    </div>
                </div>
                 <!-- Returns, Recharges & Refunds -->
                <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-undo display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Returns, Recharges & Refunds</h5>
                            <p class="card-text">Information on how to return an item, request a refund, and recharges.</p>
                        </div>
                    </div>
                </div>
                 <!-- Products & Availability -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-tags display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Products & Availability</h5>
                            <p class="card-text">Find details about our product stock, features, and availability.</p>
                        </div>
                    </div>
                </div>
                 <!-- Cart, Coupons & Offers -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Cart, Coupons & Offers</h5>
                            <p class="card-text">Get help with your shopping cart, applying coupons, and special offers.</p>
                        </div>
                    </div>
                </div>
                 <!-- Account & Security -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-user-shield display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Account & Security</h5>
                            <p class="card-text">Manage your account settings, password, and learn about security.</p>
                        </div>
                    </div>
                </div>
                 <!-- Seller & Partner Help -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-users display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Seller & Partner Help</h5>
                            <p class="card-text">Support resources for our valued sellers and business partners.</p>
                        </div>
                    </div>
                </div>
                 <!-- Order Issues & Resolutions -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-exclamation-triangle display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Order Issues & Resolutions</h5>
                            <p class="card-text">Help with incorrect, damaged, or missing items in your order.</p>
                        </div>
                    </div>
                </div>
                 <!-- Technical Support -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-cog display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Technical Support</h5>
                            <p class="card-text">Get assistance with website errors, app issues, or other technical problems.</p>
                        </div>
                    </div>
                </div>
                 <!-- Policies & Legal -->
                 <div class="col">
                    <div class="card h-100 text-center support-card p-2">
                        <div class="card-body">
                            <i class="fas fa-shield-alt display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Policies & Legal</h5>
                            <p class="card-text">Read our terms of service, privacy policy, and other legal information.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information Section -->
        <section class="my-5">
            <div class="contact-box p-4 p-md-5">
                <div class="row g-4 justify-content-center align-items-center text-center text-lg-start">
                    <div class="col-lg-5 d-flex align-items-center justify-content-center justify-content-lg-end">
                        <i class="fas fa-comments display-4 me-3"></i>
                        <span class="fs-5 fw-bold text-dark">+8801800000000</span>
                    </div>
                    <div class="col-lg-5 d-flex align-items-center justify-content-center justify-content-lg-start">
                        <i class="fas fa-envelope display-4 me-3"></i>
                        <span class="fs-5 fw-bold text-dark">info@premierweb.org</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Answers Hub (FAQ) Section -->
        <section class="py-5">
            <h2 class="text-center mb-3 fw-bold text-primary">Quick Answers Hub</h2>
            <p class="text-center text-muted mb-5 col-md-8 mx-auto">
                Find quick answers to common questions about our products, services, and policies. If you don't find what you're looking for, feel free to contact our support team directly at <a href="mailto:info@premierweb.org" class="text-decoration-none fw-medium">info@premierweb.org</a>.
            </p>
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordionLeft">
                        <!-- Item 1: Open by default -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingLeftOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeftOne" aria-expanded="true" aria-controls="collapseLeftOne">
                                    My payment failed, but money was deducted. What should I do?
                                </button>
                            </h2>
                            <div id="collapseLeftOne" class="accordion-collapse collapse show" aria-labelledby="headingLeftOne" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    If your payment failed but the amount was deducted, please wait for 5-7 business days. The amount is usually reversed back to your account automatically by the bank.
                                </div>
                            </div>
                        </div>
                        <!-- Item 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingLeftTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeftTwo" aria-expanded="false" aria-controls="collapseLeftTwo">
                                    How do I get an invoice or payment receipt?
                                </button>
                            </h2>
                            <div id="collapseLeftTwo" class="accordion-collapse collapse" aria-labelledby="headingLeftTwo" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    You can find the invoice for every completed order in your account's 'Order History' section.
                                </div>
                            </div>
                        </div>
                        <!-- Add other left-side questions here -->
                        <div class="accordion-item">
                             <h2 class="accordion-header" id="headingLeftThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeftThree" aria-expanded="false" aria-controls="collapseLeftThree">
                                   How can I track my order?
                                </button>
                            </h2>
                            <div id="collapseLeftThree" class="accordion-collapse collapse" aria-labelledby="headingLeftThree" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                   Once your order is shipped, you will receive an email with the tracking number.
                                </div>
                            </div>
                        </div>
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingLeftFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeftFour" aria-expanded="false" aria-controls="collapseLeftFour">
                                   What's the difference between a Customer and a seller account?
                                </button>
                            </h2>
                            <div id="collapseLeftFour" class="accordion-collapse collapse" aria-labelledby="headingLeftFour" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    A customer account is for buying, while a seller account is for selling products on our platform.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                     <div class="accordion" id="faqAccordionRight">
                        <!-- Item 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingRightOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRightOne" aria-expanded="false" aria-controls="collapseRightOne">
                                    What is your return or exchange policy?
                                </button>
                            </h2>
                            <div id="collapseRightOne" class="accordion-collapse collapse" aria-labelledby="headingRightOne" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                     We offer a 14-day return and exchange policy for most items. Please visit our 'Returns Policy' page for details.
                                </div>
                            </div>
                        </div>
                        <!-- Item 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingRightTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRightTwo" aria-expanded="false" aria-controls="collapseRightTwo">
                                   Can I exchange for a different size or color?
                                </button>
                            </h2>
                            <div id="collapseRightTwo" class="accordion-collapse collapse" aria-labelledby="headingRightTwo" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                   Yes, exchanges are available for different sizes or colors of the same product, subject to availability.
                                </div>
                            </div>
                        </div>
                        <!-- Add other right-side questions here -->
                         <div class="accordion-item">
                            <h2 class="accordion-header" id="headingRightThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRightThree" aria-expanded="false" aria-controls="collapseRightThree">
                                   How do I register as a Seller?
                                </button>
                            </h2>
                            <div id="collapseRightThree" class="accordion-collapse collapse" aria-labelledby="headingRightThree" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                   You can register as a seller by visiting the 'Sell on Premier Web' page and filling out the registration form.
                                </div>
                            </div>
                        </div>
                         <div class="accordion-item">
                            <h2 class="accordion-header" id="headingRightFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRightFour" aria-expanded="false" aria-controls="collapseRightFour">
                                   What are your support hours and response times?
                                </button>
                            </h2>
                            <div id="collapseRightFour" class="accordion-collapse collapse" aria-labelledby="headingRightFour" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                   Our support team is available from 9 AM to 6 PM. We aim to respond to all queries within 24 hours.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</section>
@endsection


@section('script')

@endsection