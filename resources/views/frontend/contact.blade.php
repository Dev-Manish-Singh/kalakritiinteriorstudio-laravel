@extends('frontend.master.master')
@section('title', 'Contact Us')
@section('content')

<!-- page-title -->
<section class="page-title p_relative">
    <div class="bg-layer" style="background-image: url('{{ asset('assets/images/background/page-title.jpg') }}');"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1>Contact Us</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->


<!-- contact-style-three -->
<section class="contact-style-three pt_110 pb_120">
    <div class="auto-container">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mb-4">{{ $errors->first() }}</div>
        @endif

        <div class="sec-title mb_50">
            <span class="sub-title mb_10">get in touch</span>
            <h2>We Love to Hear From You</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-7 col-md-12 col-sm-12 form-column">
                <div class="form-inner">
                    <form method="post" action="{{ route('contact.submit') }}" id="contact-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name *" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email *" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Phone Number *" required value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Message *" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="form-group message-btn pt_25">
                            <button type="submit" class="theme-btn" name="submit-form">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 info-column">
                <div class="info-content ml_70">
                    <h2>Our Address</h2>
                    <p>Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service.</p>
                    <ul class="info-list clearfix">
                        <li>
                            <div class="icon"><img src="{{ asset('assets/images/icons/icon-67.png') }}" alt=""></div>
                            <h5>Address :</h5>
                            <p>54B, Tailstoi Town 5238 MT, La city, IA 5224</p>
                        </li>
                        <li>
                            <div class="icon"><img src="{{ asset('assets/images/icons/icon-68.png') }}" alt=""></div>
                            <h5>Phone :</h5>
                            <p><a href="tel:18004567890">1800 456 7890</a> / <a href="tel:12548973654">1254 897 3654</a></p>
                        </li>
                        <li>
                            <div class="icon"><img src="{{ asset('assets/images/icons/icon-69.png') }}" alt=""></div>
                            <h5>Email :</h5>
                            <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-style-three end -->


<!-- google-map -->
<section class="google-map-section p_relative">
    <div class="map-inner">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55945.16225505631!2d-73.90847969206546!3d40.66490264739892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1601263396347!5m2!1sen!2sbd" width="100%" height="500" frameborder="0" style="border:0; width: 100%" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
</section>
<!-- google-map end -->

@endsection
