@extends('frontend.master.master')
@section('title', $blog->title)
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
                    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Blog Details</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blog') }}">Blog</a></li>
                <li>Blog Details</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- sidebar-page-container -->
<section class="sidebar-page-container pt_120 pb_120">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="blog-details-content mr_30">
                    <div class="news-block-two">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}"></figure>
                                <div class="post-date">{{ ($blog->published_at ?? $blog->created_at)?->format('d') }}<span>{{ ($blog->published_at ?? $blog->created_at)?->format('F') }}</span></div>
                            </div>
                            <div class="lower-content">
                                <ul class="post-info">
                                    <li>By : <span>Admin</span></li>
                                    <li>{{ $blog->category }}</li>
                                    @if ($blog->tag_list)
                                        <li>{{ implode(', ', $blog->tag_list) }}</li>
                                    @endif
                                </ul>
                                <h3>{{ $blog->title }}</h3>
                                <p>{{ $blog->excerpt }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="content-one mb_50">
                        <h3>Article</h3>
                        <div class="text-box">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar">
                    <div class="sidebar-widget search-widget">
                        <div class="search-form">
                            <form action="{{ route('blog') }}" method="get">
                                <div class="form-group">
                                    <input type="search" name="search-field" placeholder="Enter Search Keywords" disabled>
                                    <button type="submit"><img src="{{ asset('assets/images/icons/icon-66.png') }}" alt=""></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                @forelse ($categories as $category)
                                    <li><span>{{ $category }}</span></li>
                                @empty
                                    <li><span>No categories yet</span></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-widget post-widget">
                        <div class="widget-title">
                            <h3>Recent News</h3>
                        </div>
                        <div class="post-inner">
                            @forelse ($recentBlogs as $post)
                                <div class="post">
                                    <figure class="post-thumb">
                                        <a href="{{ route('blog.details', $post) }}"><img src="{{ asset($post->image_path) }}" alt="{{ $post->title }}"></a>
                                    </figure>
                                    <h5><a href="{{ route('blog.details', $post) }}">{{ \Illuminate\Support\Str::limit($post->title, 45) }}</a></h5>
                                    <span class="post-date">{{ optional($post->published_at ?? $post->created_at)->format('d F Y') }}</span>
                                </div>
                            @empty
                                <p class="mb-0">No recent posts.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="sidebar-widget tags-widget">
                        <div class="widget-title">
                            <h3>Tags</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="tags-list clearfix">
                                @forelse ($tags as $tag)
                                    <li><span>{{ $tag }}</span></li>
                                @empty
                                    <li><span>No tags yet</span></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- sidebar-page-container end -->

@endsection
