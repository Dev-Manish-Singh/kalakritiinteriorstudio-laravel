<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminBlogController extends Controller
{
    public function index(Request $request): View
    {
        $blogItems = Blog::query()->latest('id')->get();

        $action = $request->string('action')->toString();
        $blogId = $request->integer('blog');
        $selectedBlog = $blogId ? Blog::findOrFail($blogId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedBlog = null;
        }

        if (in_array($action, ['edit', 'view'], true) && ! $selectedBlog) {
            abort(404);
        }

        return view('backend.blogs', [
            'blogItems' => $blogItems,
            'selectedBlog' => $selectedBlog,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['image_path'] = $this->storeImage($request);
        $validated['published_at'] = $validated['published_at'] ?? now()->toDateString();

        Blog::create($validated);

        return redirect()
            ->route('admin.blogs', ['action' => 'create'])
            ->with('success', 'Blog added successfully.');
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $this->validatePayload($request, false, $blog->id);
        $validated['slug'] = $this->uniqueSlug($validated['title'], $blog->id);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['published_at'] = $validated['published_at'] ?? now()->toDateString();

        if ($request->hasFile('image')) {
            $this->deleteImage($blog->image_path);
            $validated['image_path'] = $this->storeImage($request);
        }

        $blog->update($validated);

        return redirect()
            ->route('admin.blogs', ['action' => 'edit', 'blog' => $blog->id])
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->deleteImage($blog->image_path);
        $blog->delete();

        return redirect()
            ->route('admin.blogs', ['action' => 'create'])
            ->with('success', 'Blog deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $blogs = Blog::query()->whereIn('id', $validated['ids'])->get();

        foreach ($blogs as $blog) {
            $this->deleteImage($blog->image_path);
            $blog->delete();
        }

        return redirect()
            ->route('admin.blogs', ['action' => 'create'])
            ->with('success', 'Selected blogs deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs', 'title')->ignore($ignoreId),
            ],
            'category' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:1000'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $count = 1;

        while (
            Blog::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    protected function storeImage(Request $request): string
    {
        $file = $request->file('image');
        $directory = base_path('../public_html/uploads/blogs');

        File::ensureDirectoryExists($directory);

        $filename = Str::slug($request->input('title')) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/blogs/' . $filename;
    }

    protected function deleteImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = base_path('../public_html/' . $path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
