@extends('frontend.master.master')
@section('title', 'Blog')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url(assets/images/background/page-title.jpg);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Blog</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Blog</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- blog-grid -->
<section class="blog-grid pt_120 pb_120">
    <div class="auto-container">
        <div class="row clearfix">
            @forelse ($blogs as $blog)
                @php
                    $date = $blog->published_at ?? $blog->created_at;
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                    <div class="news-block-two">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ route('blog.details', $blog) }}">
                                        <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}">
                                    </a>
                                </figure>
                                <div class="post-date">{{ $date?->format('d') }}<span>{{ $date?->format('F') }}</span></div>
                            </div>
                            <div class="lower-content">
                                <ul class="post-info">
                                    <li>By : <span>Admin</span></li>
                                    <li>{{ $blog->category }}</li>
                                </ul>
                                <h3><a href="{{ route('blog.details', $blog) }}">{{ $blog->title }}</a></h3>
                                <p>{{ \Illuminate\Support\Str::limit($blog->excerpt, 180) }}</p>
                                <div class="btn-box"><a href="{{ route('blog.details', $blog) }}" class="theme-btn">read more</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="mb-0">No blog posts found yet.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- blog-grid end -->

@endsection
