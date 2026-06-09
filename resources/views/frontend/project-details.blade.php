@extends('frontend.master.master')
@section('title', $project->title . ' - Project Details')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Project Details</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('project') }}">Projects</a></li>
                <li>{{ $project->title }}</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- project-details -->
<section class="project-details pt_120 pb_120">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 content-side">
                <div class="project-details-content">
                    <div class="content-one">
                        <h2>{{ $project->title }}</h2>
                        <p>{{ $project->summary }}</p>
                        <p>{{ $project->description }}</p>
                    </div>
                    <div class="content-two">
                        <h3>{{ $project->challenge_title ?: 'The Challenge in Installation' }}</h3>
                        <p>{{ $project->challenge_content ?: $project->description }}</p>
                        @if ($project->quote_text)
                            <blockquote>
                                <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-62.png') }}" alt=""></div>
                                <p>{{ $project->quote_text }}</p>
                                @if ($project->quote_author)
                                    <span>{{ $project->quote_author }}</span>
                                @endif
                            </blockquote>
                        @endif
                    </div>
                    <div class="content-three">
                        <h3>{{ $project->final_title ?: 'The Final View of Project' }}</h3>
                        <p>{{ $project->final_content ?: $project->description }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                <div class="image-box">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <figure class="image"><img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}"></figure>
                        </div>
                        @if ($project->secondary_image_path)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <figure class="image"><img src="{{ asset($project->secondary_image_path) }}" alt="{{ $project->title }}"></figure>
                            </div>
                        @endif
                        @if ($project->tertiary_image_path)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <figure class="image"><img src="{{ asset($project->tertiary_image_path) }}" alt="{{ $project->title }}"></figure>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- project-details end -->

@endsection
