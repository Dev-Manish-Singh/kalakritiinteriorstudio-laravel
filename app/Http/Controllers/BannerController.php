<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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

        return view('frontend.index', compact('banners', 'testimonials'));
    }
}
