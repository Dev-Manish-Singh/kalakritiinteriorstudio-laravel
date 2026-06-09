@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Profile')
@section('page_heading', 'Profile')
@section('content')
    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Account settings</p>
            <h2>Update your personal details and password from one place.</h2>
        </div>
        <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button type="submit" class="btn ia-btn-gold">
                <em class="icon ni ni-signout"></em><span>Logout</span>
            </button>
        </form>
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

    <section class="row g-gs">
        <div class="col-xl-6">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Profile info</p>
                            <h3>Change account data</h3>
                        </div>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="post" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn ia-btn-gold">
                                <em class="icon ni ni-save"></em><span>Save Profile</span>
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
                            <p class="ia-kicker">Security</p>
                            <h3>Change password</h3>
                        </div>
                    </div>

                    <form action="{{ route('admin.profile.password') }}" method="post" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn ia-btn-gold">
                                <em class="icon ni ni-lock-alt"></em><span>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
