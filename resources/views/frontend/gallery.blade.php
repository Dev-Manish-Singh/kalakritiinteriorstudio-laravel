@extends('frontend.master.master')
@section('title', 'Image Gallery')
@section('content')

    <!-- page-title -->
    <section class="page-title p_relative">
        <div class="bg-layer" style="background-image: url(assets/images/background/page-title-2.jpg);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1>Image Gallery</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Gallery</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- page-title end -->


    <!-- gallery-section -->
    <section class="project-section project-page pb_100 white-bg">
        <div class="auto-container">
            <div class="sec-title mb_75 centred">
                <span class="sub-title mb_14">our gallery</span>
                <h2>Our Kitchen Image Gallery</h2>
            </div>
            <div class="row clearfix">
                @forelse ($galleries as $gallery)
                    <div class="col-lg-3 col-md-6 col-sm-12 project-block">
                        <div class="project-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="{{ asset($gallery->image_path) }}" alt="{{ $gallery->title }}"></figure>
                                    <figure class="overlay-image"><img src="{{ asset($gallery->image_path) }}" alt="{{ $gallery->title }}"></figure>
                                </div>
                                <div class="content-box">
                                    <ul class="info-list clearfix">
                                        <li>
                                            <a href="{{ asset($gallery->image_path) }}" class="lightbox-image" data-fancybox="gallery">
                                                <img src="assets/images/icons/icon-14.png" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="text-box">
                                        <p>{{ $gallery->category }}</p>
                                        <h3>{{ $gallery->title }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="mb-0">No gallery images available yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- gallery-section end -->

@endsection
