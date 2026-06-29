@extends('backend.master.master')
@section('title', 'Admin Login')
@section('content')
@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mb-3">
        {{ $errors->first() }}
    </div>
@endif
<div class="card overflow-hidden card-gutter-lg rounded-4 card-auth card-auth-mh">
    <div class="row g-0 flex-lg-row-reverse">
        <div class="col-lg-5">
            <div class="card-body h-100 d-flex flex-column justify-content-center">
                <div class="nk-block-head text-center">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title mb-1">Login to Account</h3>
                        <p class="small">Please sign-in to your account and start the dashboard.</p>
                    </div>
                </div>
                <form action="{{ route('admin.login.submit') }}" method="post">
                    @csrf
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email_or_username" class="form-label">Email or Username</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="email_or_username" id="email_or_username" value="{{ old('email_or_username') }}" placeholder="Enter email or username">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="form-control-wrap">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-check form-check-sm">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe"> Remember Me </label>
                                </div>
                                <a href="#" class="small">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Login to account</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <!-- <p class="small">Don't have an account? <a href="{{ route('admin.register') }}">Register</a></p> -->
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card-body bg-darker is-theme has-mask has-mask-1 h-100 d-flex flex-column justify-content-end">
                <div class="mask mask-1"></div>
                <div class="brand-logo">
                    <a href="{{ url('/admin') }}" class="logo-link">
                        <div class="logo-wrap">
                            <img src="{{ asset('assets/images/logo-2.png') }}" alt="Logo" style="max-height: 34px;">
                        </div>
                    </a>
                </div>
                <div class="row">
                    <div class="col-sm-11">
                        <div class="mt-4">
                            <div class="h1 title mb-3">Welcome back to <br> your dashboard</div>
                            <p>Manage your projects, services, and business activities from one central place.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="mt-5">
                    <div class="media-group media-group-overlap">
                        <div class="media media-sm media-circle media-border border-white"><img src="{{ asset('backend/images/avatar/a.jpg') }}" alt=""></div>
                        <div class="media media-sm media-circle media-border border-white"><img src="{{ asset('backend/images/avatar/b.jpg') }}" alt=""></div>
                        <div class="media media-sm media-circle media-border border-white"><img src="{{ asset('backend/images/avatar/c.jpg') }}" alt=""></div>
                        <div class="media media-sm media-circle media-border border-white"><img src="{{ asset('backend/images/avatar/d.jpg') }}" alt=""></div>
                    </div>
                    <p class="small mt-2">Static page only for now, as requested.</p>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
