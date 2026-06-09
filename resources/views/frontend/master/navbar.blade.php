        <!-- main header -->
        <header class="main-header">
            <div class="shape z_1 float-bob-y" style="background-image: url('{{ asset('assets/images/shape/shape-2.png') }}');"></div>
            <!-- header-top -->
            <div class="header-top">
                <div class="bg-shape" style="background-image: url('{{ asset('assets/images/shape/shape-1.png') }}');"></div>
                <div class="inner-container">
                    <div class="top-inner">
                        <div class="left-column">
                            <ul class="info-list">
 <li><img src="{{ asset('assets/images/icons/icon-1.png') }}" alt="">Call for help: <a href="tel:18004567890"><span>(+1800) 456 7890</span></a></li>
 <li><img src="{{ asset('assets/images/icons/icon-2.png') }}" alt=""><a href="{{ route('contact') }}">Book An Appointment</a></li>
                            </ul>
                            <ul class="social-links">
                                 <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                 <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                 <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                 <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-lower -->
            <div class="header-lower">
                <div class="inner-container">
                    <div class="outer-box">
 <figure class="logo-box"><a href="{{ route('home') }}"><img src="{{ asset(\App\Models\Setting::logoPath('assets/images/logo.png')) }}" alt=""></a></figure>
                        <div class="menu-area">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler">
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                            </div>
                            <nav class="main-menu navbar-expand-md navbar-light clearfix">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                        <li><a href="{{ route('service') }}">Services</a></li>
                                        <li><a href="{{ route('project') }}">Projects</a></li>
                                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                        <li><a href="{{ route('blog') }}">Blog</a></li>
                                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                    </ul>
                                </div>
                            </nav>
                            
 <!-- <div class="nav-btn nav-toggler navSidebar-button clearfix"><img src="{{ asset('assets/images/icons/icon-4.png') }}" alt=""></div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!--sticky Header-->
            <div class="sticky-header">
                <div class="inner-container">
                    <div class="outer-box">
 <figure class="logo-box"><a href="{{ route('home') }}"><img src="{{ asset(\App\Models\Setting::logoPath('assets/images/logo.png')) }}" alt=""></a></figure>
                        <div class="menu-area">
                            <nav class="main-menu clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </nav>
                            
 <!-- <div class="nav-btn nav-toggler navSidebar-button clearfix"><img src="{{ asset('assets/images/icons/icon-4.png') }}" alt=""></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- main-header end -->


        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><i class="fas fa-times"></i></div>
            
            <nav class="menu-box">
 <div class="nav-logo"><a href="{{ route('home') }}"><img src="{{ asset(\App\Models\Setting::logoPath('assets/images/logo.png')) }}" alt="" title=""></a></div>
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <div class="contact-info">
                    <h4>Contact Info</h4>
                    <ul>
                        <li>Chicago 12, Melborne City, USA</li>
                        <li><a href="tel:+8801682648101">+88 01682648101</a></li>
                        <li><a href="mailto:info@example.com">info@example.com</a></li>
                    </ul>
                </div>
                <div class="social-links">
                    <ul class="clearfix">
                         <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                         <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                         <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                         <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                         <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->
