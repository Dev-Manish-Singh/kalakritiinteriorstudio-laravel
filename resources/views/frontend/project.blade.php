@extends('frontend.master.master')
@section('title', 'Projects')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title-2.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Projects</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Projects</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- project-section -->
<section class="project-section project-page pb_100 white-bg">
    <div class="auto-container">
        <div class="sec-title mb_75">
            <span class="sub-title mb_14">our work</span>
            <h2>Explore Recent Projects</h2>
            <p class="pt_10">Browse the latest completed project stories and tap into the one you want to inspect in detail.</p>
        </div>
        <div class="row clearfix">
            @forelse ($projects as $project)
                <div class="col-lg-6 col-md-6 col-sm-12 project-block">
                    <div class="project-block-one">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}"></figure>
                                <figure class="overlay-image"><img src="{{ asset($project->overlay_image_path ?: $project->image_path) }}" alt="{{ $project->title }}"></figure>
                            </div>
                            <div class="content-box">
                                <ul class="info-list clearfix">
                                    <li>
                                        <a href="{{ asset($project->image_path) }}" class="lightbox-image" data-fancybox="gallery">
                                            <img src="{{ asset('assets/images/icons/icon-14.png') }}" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('project.details', $project) }}">
                                            <img src="{{ asset('assets/images/icons/icon-15.png') }}" alt="">
                                        </a>
                                    </li>
                                </ul>
                                <div class="text-box">
                                    <p>{{ $project->category }}</p>
                                    <h3><a href="{{ route('project.details', $project) }}">{{ $project->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No projects found yet. Please add projects from the admin panel.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- project-section end -->

@endsection
