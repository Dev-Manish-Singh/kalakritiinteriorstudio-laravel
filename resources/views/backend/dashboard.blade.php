@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Dashboard')
@section('page_heading', 'Dashboard')
@section('content')
    @php
        $totalItems = collect($stats)->sum('count');
    @endphp

    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Today overview</p>
            <h2>Manage banners, blogs, services, projects, gallery, testimonials, and inquiries from one dashboard.</h2>
            <!-- <p class="text-secondary mb-0">Total content items: <strong>{{ $totalItems }}</strong></p> -->
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.projects') }}">
            <em class="icon ni ni-building"></em><span>Open Projects</span>
        </a>
    </section>

    <section class="ia-stat-grid">
        @foreach($stats as $stat)
            <a class="card ia-card text-decoration-none" href="{{ $stat['link'] }}">
                <div class="card-body">
                    <p class="ia-kicker mb-1">{{ $stat['label'] }}</p>
                    <h3 class="mb-0">{{ $stat['count'] }}</h3>
                </div>
            </a>
        @endforeach
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card mb-4">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Recent work</p>
                            <h3>Recent Projects</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.projects') }}">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-middle ia-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProjects as $project)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($project->title, 45) }}</td>
                                        <td>{{ $project->category ?: '-' }}</td>
                                        <td><span class="ia-badge {{ $project->is_active ? 'active' : 'draft' }}">{{ $project->is_active ? 'Active' : 'Draft' }}</span></td>
                                        <td>{{ optional($project->updated_at ?? $project->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No projects found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card ia-card mb-4">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Content library</p>
                            <h3>Recent Blogs</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.blogs') }}">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-middle ia-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Published</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBlogs as $blog)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($blog->title, 45) }}</td>
                                        <td>{{ $blog->category ?: '-' }}</td>
                                        <td><span class="ia-badge {{ $blog->is_active ? 'active' : 'draft' }}">{{ $blog->is_active ? 'Active' : 'Draft' }}</span></td>
                                        <td>{{ optional($blog->published_at ?? $blog->updated_at ?? $blog->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No blogs found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card ia-card">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Visual assets</p>
                            <h3>Recent Gallery</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.gallery') }}">View All</a>
                    </div>
                    <div class="row g-3">
                        @forelse($recentGallery as $item)
                            <div class="col-sm-6 col-lg-4">
                                <div class="border rounded-3 p-2 h-100">
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="img-fluid rounded-2 mb-2" style="aspect-ratio: 4 / 3; object-fit: cover;">
                                    <strong class="d-block">{{ \Illuminate\Support\Str::limit($item->title, 36) }}</strong>
                                    <small class="text-muted">{{ $item->category ?: 'Gallery' }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">No gallery images found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card ia-card mb-4">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Service spotlight</p>
                            <h3>Recent Services</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.services') }}">View All</a>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($recentServices as $service)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <strong class="d-block">{{ \Illuminate\Support\Str::limit($service->title, 38) }}</strong>
                                        <small class="text-muted">{{ \Illuminate\Support\Str::limit($service->excerpt ?: $service->content, 80) }}</small>
                                    </div>
                                    <span class="ia-badge {{ $service->is_active ? 'active' : 'draft' }}">{{ $service->is_active ? 'Active' : 'Draft' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted">No services found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card ia-card mb-4">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Social proof</p>
                            <h3>Testimonials</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.testimonials') }}">View All</a>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($recentTestimonials as $testimonial)
                            <div class="list-group-item px-0">
                                <strong class="d-block">{{ $testimonial->name }}</strong>
                                <small class="text-muted d-block">{{ trim(($testimonial->designation ?: '') . ($testimonial->company ? ' at ' . $testimonial->company : '')) ?: 'Testimonial' }}</small>
                                <p class="mb-0 text-secondary">{{ \Illuminate\Support\Str::limit($testimonial->feedback, 90) }}</p>
                            </div>
                        @empty
                            <div class="text-muted">No testimonials found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card ia-card">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">New inquiry</p>
                            <h3>Latest Inquiries</h3>
                        </div>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.inquiries') }}">View All</a>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($recentInquiries as $inquiry)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <strong class="d-block">{{ $inquiry->name }}</strong>
                                        <small class="text-muted d-block">{{ $inquiry->email }}</small>
                                        <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($inquiry->message, 90) }}</small>
                                    </div>
                                    <span class="ia-badge {{ ($inquiry->status ?? 'new') === 'new' ? 'active' : 'draft' }}">
                                        {{ ucfirst($inquiry->status ?? 'new') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted">No inquiries found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
