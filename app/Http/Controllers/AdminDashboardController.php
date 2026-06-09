<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            [
                'label' => 'Banners',
                'count' => Banner::count(),
                'link' => route('admin.banners'),
            ],
            [
                'label' => 'Blogs',
                'count' => Blog::count(),
                'link' => route('admin.blogs'),
            ],
            [
                'label' => 'Services',
                'count' => Service::count(),
                'link' => route('admin.services'),
            ],
            [
                'label' => 'Projects',
                'count' => Project::count(),
                'link' => route('admin.projects'),
            ],
            [
                'label' => 'Gallery',
                'count' => Gallery::count(),
                'link' => route('admin.gallery'),
            ],
            [
                'label' => 'Testimonials',
                'count' => Testimonial::count(),
                'link' => route('admin.testimonials'),
            ],
            [
                'label' => 'Inquiries',
                'count' => Inquiry::count(),
                'link' => route('admin.inquiries'),
            ],
        ];

        return view('backend.dashboard', [
            'stats' => $stats,
            'recentProjects' => Project::query()->latest()->take(5)->get(),
            'recentServices' => Service::query()->latest()->take(5)->get(),
            'recentBlogs' => Blog::query()->latest()->take(5)->get(),
            'recentTestimonials' => Testimonial::query()->latest()->take(5)->get(),
            'recentGallery' => Gallery::query()->latest()->take(5)->get(),
            'recentInquiries' => Inquiry::query()->latest()->take(5)->get(),
        ]);
    }
}
