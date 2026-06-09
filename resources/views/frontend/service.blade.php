@extends('frontend.master.master')
@section('title', 'Services')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Services</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Services</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- service-style-two -->
<section class="service-style-two bg-color-2 pt_100 pb_110">
    <div class="auto-container">
        <div class="sec-title mb_60">
            <span class="sub-title mb_11">Our services</span>
            <h2>What We Do</h2>
            <p>If you need to repair or replace your kitchen system, call today and talk to one of our kitchen specialists. They'll answer your questions and arrange an appointment at your convenience.</p>
        </div>
        <div class="row clearfix">
            @forelse ($services as $service)
                <div class="col-lg-3 col-md-6 col-sm-12 service-block">
                    <div class="service-block-two wow fadeInUp animated" data-wow-delay="{{ ($loop->index % 4) * 200 }}ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="icon-box">
                                <img src="{{ asset($service->icon_path) }}" alt="{{ $service->title }}">
                            </div>
                            <h3>
                                <a href="{{ route('service.details', $service) }}">{{ $service->title }}</a>
                            </h3>
                            <p class="mt_10">{{ $service->excerpt }}</p>
                            <div class="link">
                                <a href="{{ route('service.details', $service) }}">Learn more <img src="{{ asset('assets/images/icons/icon-47.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No services found yet. Please add services from the admin panel.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- service-style-two end -->


<!-- chooseus-section -->
<section class="chooseus-section bg-color-2 pb_120">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-31.png') }}" alt=""></div>
                        <h4>Reasonable Prices</h4>
                        <p>We produce furniture to fulfill needs of all people and offer it at affordable and fair prices</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-32.png') }}" alt=""></div>
                        <h4>Professional Team</h4>
                        <p>We are proud of our amicable, professional and always developing team</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-33.png') }}" alt=""></div>
                        <h4>Exclusive Design</h4>
                        <p>Mixture of imagination, experience and professionalism is the secret of our design</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- chooseus-section -->


<!-- video-section -->
<section class="video-section">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/video-bg.jpg') }}');"></div>
    <div class="outer-container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content_block_two">
                    <div class="content-box">
                        <h2>Our core values allow us to stay on track and <span>innovate in design.</span></h2>
                        <h3>Feel good experience from design to installation</h3>
                        <p>We are following all protocols to ensure your safety and our installation workflow stays smooth and reliable.</p>
                        <a href="{{ route('home') }}" class="theme-btn">Checkout videos</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 video-column">
                <div class="video_block_one">
                    <div class="video-content ml_75 mr_60">
                        <div class="video-box" style="background-image: url('{{ asset('assets/images/resource/video-1.jpg') }}');">
                            <div class="video-btn">
                                <a href="https://www.youtube.com/watch?v=nfP5N9Yc72A&amp;t=28s" class="lightbox-image" data-caption=""><img src="{{ asset('assets/images/icons/icon-19.png') }}" alt=""><span class="border-animation"></span><span class="border-animation border-1"></span><span class="border-animation border-2"></span><span class="border-animation border-3"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- video-section end -->

@endsection
