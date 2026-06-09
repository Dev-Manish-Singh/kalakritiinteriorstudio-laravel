@extends('backend.master.admin')
@section('title', $pageTitle ?? 'Admin Page')
@section('page_heading', $pageTitle ?? 'Admin Page')
@section('content')
    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Static admin page</p>
            <h2>{{ $pageHeading ?? 'Content page' }}</h2>
        </div>
        <a class="btn btn-outline-dark" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
    </section>

    <div class="card ia-card">
        <div class="card-body">
            <p class="mb-0">{{ $pageDescription ?? 'This page is now served from a Blade view and linked through Laravel routes.' }}</p>
        </div>
    </div>
@endsection
