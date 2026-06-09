@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Settings')
@section('page_heading', 'Settings')
@section('content')
    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Brand settings</p>
            <h2>Update the frontend header logo from here.</h2>
        </div>
        <a class="btn btn-outline-dark" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
    </section>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-gs">
        <div class="col-xl-6">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Frontend logo</p>
                            <h3>Header logo</h3>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="mb-2">Current Logo</p>
                        <img src="{{ asset($siteLogo) }}" alt="Current logo" style="max-height: 80px; width: auto;">
                    </div>

                    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" class="row g-3">
                        @csrf

                        <div class="col-12">
                            <label class="form-label">Upload Logo <span class="text-danger">*</span> <small class="text-muted">(194 × 49 px)</small></label>
                            <input type="file" name="site_logo" class="form-control" accept=".png,.jpg,.jpeg,.webp,.svg">
                            <small class="text-muted d-block mt-1">Recommended: transparent PNG/SVG for the header.</small>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn ia-btn-gold">
                                <em class="icon ni ni-upload"></em><span>Update Logo</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Usage</p>
                            <h3>Where the logo is used</h3>
                        </div>
                    </div>

                    <ul class="ia-check-list">
                        <li>Frontend header logo</li>
                        <li>Frontend mobile menu logo</li>
                        <li>Frontend footer logo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
