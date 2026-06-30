@extends('frontend.master.master')
@section('title', $service->title . ' - Service Details')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Service Details</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li>{{ $service->title }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- project-details style service details -->
<section class="project-details pt_120 pb_120">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-7 col-md-12 col-sm-12 content-side">
                <div class="project-details-content">
                    <div class="content-one">
                        <h2>{{ $service->title }}</h2>
                        <p>{{ $service->excerpt }}</p>
                        <p>{{ $service->content }}</p>
                    </div>
                    <div class="content-two">
                        <h3>What We Cover</h3>
                        <ul class="list-style-one clearfix">
                            @forelse ($service->highlight_list as $highlight)
                                <li>{{ $highlight }}</li>
                            @empty
                                <li>Custom service planning based on your requirements</li>
                                <li>Material selection, layout planning, and execution</li>
                                <li>Installation support with final finishing</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="content-three">
                        <h3>How We Work</h3>
                        <p>{{ $service->process_content }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 image-column">
                <div class="image-box">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <figure class="image">
                                <img src="{{ asset($service->image_path) }}" alt="{{ $service->title }}">
                            </figure>
                        </div>
                        @if ($service->secondary_image_path)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <figure class="image">
                                    <img src="{{ asset($service->secondary_image_path) }}" alt="{{ $service->title }}">
                                </figure>
                            </div>
                        @endif
                        @if ($service->tertiary_image_path)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <figure class="image">
                                    <img src="{{ asset($service->tertiary_image_path) }}" alt="{{ $service->title }}">
                                </figure>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- service-details end -->


<!-- chooseus-section -->
<section class="chooseus-section service-details-chooseus bg-color-2 pt_100 pb_100">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-31.png') }}" alt=""></div>
                        <h4>Smart Planning</h4>
                        <p>Every inch of your kitchen is planned for maximum storage and smooth daily movement.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-32.png') }}" alt=""></div>
                        <h4>Expert Team</h4>
                        <p>Experienced designers and installers ensure precise execution and premium finish quality.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                <div class="chooseus-block-one">
                    <div class="inner-box">
                        <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-33.png') }}" alt=""></div>
                        <h4>Custom Design</h4>
                        <p>Your kitchen theme, color palette, and materials are curated around your lifestyle.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- chooseus-section end -->

@endsection
