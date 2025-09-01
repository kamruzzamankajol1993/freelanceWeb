@extends('front.master.master')
@section('title')
About Us
@endsection

@section('css')

@endsection

@section('body')
 <!-- Hero Section -->
    <section class="page-hero-section px-md-0 px-3">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="page-hero-title">Meet Premier Web Retail </h2>
            <div class="page-hero-nav-links bg-white rounded">
              <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#about">About Us</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Content Section -->
    <!-- Content Section -->
    <section class="content-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class=" col-12">
            <div class="content-overlay">
              <h2 class="section-title">About - Premier Web Retail </h2>

              <p class="content-text">
                Welcome to Premier Web Retail  – where convenience meets speed, and every delivery feels like magic. We're not
                just another e-commerce company. We're your personal pickup partner, your delivery sidekick, and your
                go-to marketplace – all rolled into one. From daily must-haves to last-minute surprises, we make sure
                everything you need gets from point A to point B, quick, easy, and hassle-free.
              </p>

              <h3 class="section-subtitle">What Makes Us Different :</h3>

              <ul class="feature-list">
                <li>On-Demand Pickup & Delivery – From store to door, with real-time tracking.</li>
                <li>All-in-One E-commerce Platform – Shop, pay, and receive without the hassle.</li>
                <li>Business-Friendly Solutions – Scalable logistics for local businesses and online
                  sellers.</li>
              </ul>

              <p class="content-text">
                With a strong commitment to speed, service, and technology, Premier Web Retail  is redefining how goods move
                in today's digital world.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection


@section('script')

@endsection