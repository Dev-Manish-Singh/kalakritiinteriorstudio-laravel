<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view('frontend.blog', compact('blogs'));
    }

    public function show(Blog $blog): View
    {
        abort_unless($blog->is_active, 404);

        $categories = Blog::query()
            ->where('is_active', true)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $recentBlogs = Blog::query()
            ->where('is_active', true)
            ->whereKeyNot($blog->id)
            ->latest('published_at')
            ->latest('id')
            ->limit(4)
            ->get();

        $tags = collect($blog->tag_list)
            ->merge(
                Blog::query()
                    ->where('is_active', true)
                    ->pluck('tags')
                    ->flatMap(fn ($tags) => collect(explode(',', (string) $tags))->map(fn ($tag) => trim($tag)))
                    ->filter()
                    ->values()
                    ->all()
            )
            ->unique()
            ->values();

        return view('frontend.blog-details', compact('blog', 'categories', 'recentBlogs', 'tags'));
    }
}
