<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        $projects = Project::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(4)
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(4)
            ->get();

        $blogs = Blog::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get();

        return view('frontend.index', compact('banners', 'testimonials', 'projects', 'services', 'blogs'));
    }
}
