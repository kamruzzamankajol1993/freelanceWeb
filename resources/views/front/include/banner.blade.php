<section class="hero-slider">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- Loop through each slider from the database --}}
            @foreach($sliders as $slider)
                {{-- Add 'active' class to the first slider item --}}
                <div class="carousel-item @if($loop->first) active @endif">
                    <div class="hero-slide">
                        <div class="container-fluid h-lg-100">
                            <div class="row h-lg-100 align-items-center">
                                <div class="col-lg-7 col-md-6">
                                    <div class="hero-content">
                                        {{-- Display the slider title --}}
                                        <h1 class="hero-title">
                                            {!! $slider->title !!}
                                        </h1>
                                        <button onclick="location.href='{{ route('shop.show') }}'" class="btn btn-primary btn-lg hero-btn mt-4">
                                            ORDER NOW
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6">
                                    <div class="hero-image">
                                        {{-- NOTE: Assuming images are stored in 'public/uploads/sliders/' --}}
                                        <img src="{{$front_ins_url}}public/{{$slider->image}}" alt="{{ $slider->title }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="carousel-indicators">
            @foreach($sliders as $slider)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" class="@if($loop->first) active @endif"></button>
            @endforeach
        </div>
    </div>
</section>