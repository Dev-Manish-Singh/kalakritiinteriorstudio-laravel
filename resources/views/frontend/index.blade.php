@extends('frontend.master.master')
@section('title', 'Home')
@section('content')

        <!-- banner-section -->
        <section class="banner-section p_relative">
            <div class="banner-carousel owl-theme owl-carousel owl-dots-none">
                @forelse ($banners as $banner)
                    <div class="slide-item p_relative">
                        <div class="bg-layer" style="background-image: url({{ asset($banner->image_path) }});"></div>
                        <div class="inner-container">
                            <div class="content-box">
                                <h2>{{ $banner->heading }}</h2>
                                <p>{{ $banner->subheading }}</p>
                                <div class="btn-box"><a href="{{ $banner->button_link }}" class="theme-btn">{{ $banner->button_text }}</a></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="slide-item p_relative">
                        <div class="bg-layer" style="background-image: url(assets/images/banner/banner-1.jpg);"></div>
                        <div class="inner-container">
                            <div class="content-box">
                                <h2>Design Your Kitchen With Our Experts</h2>
                                <p>Inoterior design consultancy firm that brings sensitivity to the design top restaurants, hotels, offices & homes around the world. We stand for quality, safety and credibility</p>
                                <div class="btn-box"><a href="{{ route('about') }}" class="theme-btn">discover more</a></div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="year-box">Est. <br /><span>1920</span></div>
        </section>
        <!-- banner-section end -->


        <!-- about-section -->
        <section class="about-section">
            <div class="auto-container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-12 col-sm-12 image-column">
                        <div class="image-box">
                            <figure class="image image-hov-one"><img src="assets/images/resource/about-1.jpg" alt=""></figure>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12 content-column">
                        <div class="content_block_one">
                            <div class="content-box ml_40">
                                <div class="sec-title mb_25">
                                    <span class="sub-title mb_19">about our workshop</span>
                                    <h2>Discover a New Look For Your Kitchen</h2>
                                </div>
                                <div class="text-box">
                                    <p>Imagine a utopia where all of your wishes are granted and all of your desires are satisfied. From our magnificent private beach to our sophisticated palatial house, Bluebell offers unrivalled luxury. In this luxurious getaway, no expense has been spared. Our 8,000 Sq feet contemporary luxury estate can accommodate up to 20 guests.</p>
                                    <h4>You will receive special privileges and perks across many parts of our hotel and resort offers every time you stay with us.</h4>
                                </div>
                                <ul class="list-style-one clearfix">
                                    <li>Modular Kitchen</li>
                                    <li>Drafting Design</li>
                                    <li>Kitchen Planning</li>
                                    <li>Commercial Interior</li>
                                    <li>Design Discussion</li>
                                    <li>Kitchen Cabinet and more</li>
                                </ul>
                                <div class="btn-box"><a href="about.html" class="theme-btn">discover more</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-section end -->


        <!-- faq-section -->
        <style>
            .faq-section .service-card {
                height: 100%;
                padding: 32px 24px;
                border-radius: 18px;
                background: #fff;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
                border: 1px solid rgba(0, 0, 0, 0.06);
                text-align: center;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .faq-section .service-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 36px rgba(0, 0, 0, 0.1);
            }

            .faq-section .service-card__icon {
                width: 84px;
                height: 84px;
                margin: 0 auto 18px;
                border-radius: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f7f4ee;
            }

            .faq-section .service-card__icon img {
                width: 44px;
                height: 44px;
                object-fit: contain;
            }

            .faq-section .service-card__title {
                margin: 0;
                font-size: 20px;
                line-height: 1.3;
                color: #111;
            }

            .faq-section .service-card__excerpt {
                margin: 12px 0 18px;
                color: #666;
                font-size: 15px;
                line-height: 1.7;
            }

            .faq-section .service-card__link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                color: #111;
                text-decoration: none;
            }

            .faq-section .service-card__link img {
                width: 18px;
                height: 18px;
            }
        </style>
        <section class="faq-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-12 title-column text-center">
                        <div class="sec-title mb_25 centred">
                            <span class="sub-title mb_19">our services</span>
                            <h2>We provide all type of <span>modular kitchen</span> services</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-4 justify-content-center">
                            @forelse ($services as $service)
                                @php
                                    $iconPath = $service->icon_path ? asset($service->icon_path) : asset('assets/images/icons/icon-13.png');
                                @endphp
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="service-card h-100">
                                        <div class="service-card__icon">
                                            <img src="{{ $iconPath }}" alt="{{ $service->title }}">
                                        </div>
                                        <h3 class="service-card__title">
                                            <a href="{{ route('service.details', $service) }}">{{ $service->title }}</a>
                                        </h3>
                                        <p class="service-card__excerpt">{{ $service->excerpt }}</p>
                                        <a class="service-card__link" href="{{ route('service.details', $service) }}">
                                            Read More
                                            <img src="{{ asset('assets/images/icons/icon-47.png') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info text-center mb-0">Please add active services from <a href="{{ route('admin.services') }}">/admin/services</a> to show them here.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- faq-section end -->


        <!-- project-section -->
        <section class="project-section">
            <div class="auto-container">
                <div class="title-box mb_70">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 col-sm-12 title-column">
                            <div class="sec-title light">
                                <span class="sub-title mb_19">Our Projects</span>
                                <h2>Our Latest Kitchens <br />Design</h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 text-column">
                            <div class="text-box">
                                <p>The of your kitchen varies from one layout to another. The shape of the kitchen also determines the and space for cabinets, countertops, and accessories.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="outer-container pl_95 pr_95">
                <div class="row clearfix">
                    @forelse ($projects as $project)
                        <div class="col-lg-3 col-md-6 col-sm-12 project-block">
                            <div class="project-block-one">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image">
                                            <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}">
                                        </figure>
                                        <figure class="overlay-image">
                                            <img src="{{ asset($project->overlay_image_path ?: $project->image_path) }}" alt="{{ $project->title }}">
                                        </figure>
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


        <!-- funfact-section -->
        <section class="funfact-section">
            <div class="outer-container">
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                            <div class="funfact-block-one">
                                <div class="inner-box">
                                    <div class="count-outer">
                                        <span class="odometer" data-count="27">00</span><span class="symble">+</span>
                                    </div>
                                    <p>Architecture</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                            <div class="funfact-block-one">
                                <div class="inner-box">
                                    <div class="count-outer">
                                        <span class="odometer" data-count="78">00</span><span class="symble">+</span>
                                    </div>
                                    <p>Interior Designs</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                            <div class="funfact-block-one">
                                <div class="inner-box">
                                    <div class="count-outer">
                                        <span class="odometer" data-count="38">00</span><span class="symble">+</span>
                                    </div>
                                    <p>Modular Kitchens</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                            <div class="funfact-block-one">
                                <div class="inner-box">
                                    <div class="count-outer">
                                        <span class="odometer" data-count="98">00</span><span class="symble">+</span>
                                    </div>
                                    <p>Project done</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- funfact-section end -->


        <!-- testimonial-section -->
        <section class="testimonial-section centred">
            <div class="auto-container">
                <div class="single-item-carousel owl-carousel owl-theme owl-dots-none">
                    @forelse ($testimonials as $testimonial)
                        <div class="testimonial-block">
                            <div class="image-box">
                                <figure class="thumb-box"><img src="{{ asset($testimonial->image_path) }}" alt="{{ $testimonial->name }}"></figure>
                                <div class="icon-box">
                                    <img src="{{ asset($testimonial->quote_icon_path ?: 'assets/images/icons/icon-16.png') }}" alt="">
                                </div>
                            </div>
                            <div class="text-box">
                                <p>{{ $testimonial->feedback }}</p>
                                <span class="name">{{ $testimonial->name }}</span>
                                @if ($testimonial->designation || $testimonial->company)
                                    <small class="d-block mt-1">{{ $testimonial->designation }}{{ $testimonial->company ? ' , ' . $testimonial->company : '' }}</small>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="testimonial-block">
                            <div class="image-box">
                                <figure class="thumb-box"><img src="{{ asset('assets/images/resource/testimonial-1.png') }}" alt=""></figure>
                                <div class="icon-box"><img src="{{ asset('assets/images/icons/icon-16.png') }}" alt=""></div>
                            </div>
                            <div class="text-box">
                                <p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
                                <span class="name">Michale Joe</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <!-- testimonial-section end -->


        <!-- video-section -->
        <section class="video-section">
            <div class="bg-layer" style="background-image: url(assets/images/background/video-bg.jpg);"></div>
            <div class="outer-container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_two">
                            <div class="content-box">
                                <h2>Our core values allow us to stay on track and <span>innovate in design.</span></h2>
                                <h3>Feel good experience from design to installation</h3>
                                <p>We’re following all protocols to ensure your safety and vaccination drives are underway to ensure our employees.</p>
                                <a href="index-2.html" class="theme-btn">checkout videos</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 video-column">
                        <div class="video_block_one">
                            <div class="video-content ml_75 mr_60">
                                <div class="video-box" style="background-image: url(assets/images/resource/video-1.jpg);">
                                    <div class="video-btn">
                                        <a href="https://www.youtube.com/watch?v=nfP5N9Yc72A&amp;t=28s" class="lightbox-image" data-caption=""><img src="assets/images/icons/icon-19.png" alt=""><span class="border-animation"></span><span class="border-animation border-1"></span><span class="border-animation border-2"></span><span class="border-animation border-3"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- video-section end -->


        <!-- working-section -->
        <section class="working-section centred">
            <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-3.png);"></div>
            <div class="auto-container">
                <div class="sec-title mb_60 centred">
                    <span class="sub-title mb_19">how we do work</span>
                    <h2>Our Work Progress</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-12 working-block">
                        <div class="working-block-one">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon"><img src="assets/images/icons/icon-20.png" alt=""></div>
                                    <span>1</span>
                                </div>
                                <h3>Meet Customers</h3>
                                <p>Osed quia consequuntur magni dolores eos qui rati one volu ptatem sequi nesciunt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 working-block">
                        <div class="working-block-one">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon"><img src="assets/images/icons/icon-21.png" alt=""></div>
                                    <span>2</span>
                                </div>
                                <h3>Meeting On Table</h3>
                                <p>Osed quia consequuntur magni dolores eos qui rati one volu ptatem sequi nesciunt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 working-block">
                        <div class="working-block-one">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon"><img src="assets/images/icons/icon-22.png" alt=""></div>
                                    <span>3</span>
                                </div>
                                <h3>Drafting Design</h3>
                                <p>Osed quia consequuntur magni dolores eos qui rati one volu ptatem sequi nesciunt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 working-block">
                        <div class="working-block-one">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon"><img src="assets/images/icons/icon-23.png" alt=""></div>
                                    <span>4</span>
                                </div>
                                <h3>Implimentation</h3>
                                <p>Osed quia consequuntur magni dolores eos qui rati one volu ptatem sequi nesciunt.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- working-section end -->


        <!-- transforming-section -->
        <section class="transforming-section pt_120">
            <div class="outer-container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-sm-12 title-column">
                        <div class="title-text align-3">
                            <h2>Transforming <span>space into dream</span> come true</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 image-column">
                        <figure class="image-box"><img src="assets/images/resource/transforming-1.png" alt=""></figure>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 text-column">
                        <div class="text-box ml_100">
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- transforming-section end -->


        <div class="slide-text-outer p_relative pb_80 pt_60">
            <span class="text-box italic">Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish&nbsp;&nbsp;&nbsp;&nbsp;Modular Kitchen&nbsp;&nbsp;&nbsp;&nbsp;Interior&nbsp;&nbsp;&nbsp;&nbsp;Cabinet Finish</span>
        </div>


        <!-- news-section -->
        <section class="news-section bg-color-1">
            <div class="auto-container">
                <div class="sec-title centred mb_50">
                    <span class="sub-title mb_19">our blogs</span>
                    <h2>Recent News & Articles</h2>
                </div>
                <div class="row clearfix {{ $blogs->count() === 1 ? 'justify-content-center' : '' }}">
                    @forelse ($blogs as $blog)
                        @php
                            $date = $blog->published_at ?? $blog->created_at;
                            $imagePath = $blog->image_path ? asset($blog->image_path) : asset('assets/images/news/news-1.jpg');
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                            <div class="news-block-one wow fadeInUp animated" data-wow-delay="{{ ($loop->index * 300) }}ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image">
                                            <a href="{{ route('blog.details', $blog) }}">
                                                <img src="{{ $imagePath }}" alt="{{ $blog->title }}">
                                            </a>
                                        </figure>
                                        <figure class="overlay-image">
                                            <a href="{{ route('blog.details', $blog) }}">
                                                <img src="{{ $imagePath }}" alt="{{ $blog->title }}">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="post-info">
                                            <li><a href="{{ route('blog.details', $blog) }}">Admin</a></li>
                                            <li>{{ $date?->format('d M Y') }}</li>
                                        </ul>
                                        <h3><a href="{{ route('blog.details', $blog) }}">{{ $blog->title }}</a></h3>
                                        <p>{{ \Illuminate\Support\Str::limit($blog->excerpt, 110) }}</p>
                                        <div class="btn-box">
                                            <a href="{{ route('blog.details', $blog) }}" class="theme-btn">read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No blog posts found yet. Please add blogs from the admin panel.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <!-- news-section end -->




@endsection

