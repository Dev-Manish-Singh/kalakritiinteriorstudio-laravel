<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>@yield('title', 'Kalakriti')</title>

<!-- Fav Icon -->
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

<!-- Stylesheets -->
<link href="{{ asset('assets/css/font-awesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/nice-select.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/odometer.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/elpath.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/color.css') }}" id="jssDefault" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">

</head>


<!-- page wrapper -->
<body>

    <div class="boxed_wrapper">

        <!--Search Popup-->
        <div id="search-popup" class="search-popup">
            <div class="popup-inner">
                <div class="upper-box">
                    <figure class="logo-box"><a href="{{ route('home') }}"><img src="{{ asset(\App\Models\Setting::logoPath('assets/images/manish/logo_final.png')) }}" alt=""></a></figure>
                    <div class="close-search"><span class="fas fa-times"></span></div>
                </div>
                <div class="overlay-layer"></div>
                <div class="auto-container">
                    <div class="search-form">
                        <form method="post" action="https://azim.hostlin.com/Kalakriti/index.html">
                            <div class="form-group">
                                <fieldset>
                                    <input type="search" class="form-control" name="search-input" value="" placeholder="Type your keyword and hit" required >
                                    <button type="submit"><img src="{{ asset('assets/images/icons/icon-3.png') }}" alt=""></button>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- sidebar cart item -->
        <div class="xs-sidebar-group info-group info-sidebar">
            <div class="xs-overlay xs-bg-black"></div>
            <div class="xs-sidebar-widget">
                <div class="sidebar-widget-container">
                    <div class="widget-heading">
                        <a href="#" class="close-side-widget">X</a>
                    </div>
                    <div class="sidebar-textwidget">
                        <div class="sidebar-info-contents">
                            <div class="content-inner">
                                <div class="logo">
                                    <a href="{{ route('home') }}"><img src="{{ asset(\App\Models\Setting::logoPath('assets/images/logo-2.png')) }}" alt="" /></a>
                                </div>
                                <div class="text">
                                    <h3>We Are Modular Kitchen Company</h3>
                                    <p>Our experienced team offers services for both residential and commercial properties.With over 25 years of experience in the industry.</p>
                                </div>
                                <div class="info-box">
                                    <h3>Conatct Us</h3>
                                    <ul class="info clearfix">
                                        <li><div class="icon"><img src="{{ asset('assets/images/icons/icon-5.png') }}" alt=""></div>54B, Tailstoi Town 5238 MT, La city, IA 522364</li>
                                        <li><div class="icon"><img src="{{ asset('assets/images/icons/icon-6.png') }}" alt=""></div><a href="mailto:contact@example.com">contact@example.com</a></li>
                                        <li><div class="icon"><img src="{{ asset('assets/images/icons/icon-7.png') }}" alt=""></div><a href="tel:18004567890">+1800 456 7890</a></li>
                                        <li><div class="icon"><img src="{{ asset('assets/images/icons/icon-8.png') }}" alt=""></div>Working Hrs : 9.30am to 6.30pm</li>
                                    </ul>
                                </div>
                                <div class="subscribe-inner">
                                    <h3>Newsletter Subscription</h3>
                                    <form action="https://azim.hostlin.com/Kalakriti/contact.html" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Enter Email Address" required="">
                                            <button type="submit" class="theme-btn"><span>subscribe now</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END sidebar widget item -->



