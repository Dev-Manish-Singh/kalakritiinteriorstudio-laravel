<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminGalleryController extends Controller
{
    public function index(Request $request): View
    {
        $galleryItems = Gallery::query()
            ->latest('id')
            ->get();

        $action = $request->string('action')->toString();
        $galleryId = $request->integer('gallery');
        $selectedGallery = $galleryId ? Gallery::findOrFail($galleryId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedGallery = null;
        }

        if ($action === 'edit' && ! $selectedGallery) {
            abort(404);
        }

        if ($action === 'view' && ! $selectedGallery) {
            abort(404);
        }

        return view('backend.gallery', [
            'galleryItems' => $galleryItems,
            'selectedGallery' => $selectedGallery,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        $validated['image_path'] = $this->storeImage($request);

        Gallery::create($validated);

        return redirect()
            ->route('admin.gallery', ['action' => 'create'])
            ->with('success', 'Gallery image added successfully.');
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $this->validatePayload($request, false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($gallery->image_path);
            $validated['image_path'] = $this->storeImage($request);
        }

        $gallery->update($validated);

        return redirect()
            ->route('admin.gallery', ['action' => 'edit', 'gallery' => $gallery->id])
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->deleteImage($gallery->image_path);
        $gallery->delete();

        return redirect()
            ->route('admin.gallery', ['action' => 'create'])
            ->with('success', 'Gallery image deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $items = Gallery::query()->whereIn('id', $validated['ids'])->get();

        foreach ($items as $item) {
            $this->deleteImage($item->image_path);
            $item->delete();
        }

        return redirect()
            ->route('admin.gallery', ['action' => 'create'])
            ->with('success', 'Selected gallery images deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);
    }

    protected function storeImage(Request $request): string
    {
        $file = $request->file('image');
        $directory = public_path('uploads/gallery');

        File::ensureDirectoryExists($directory);

        $filename = Str::slug($request->input('title')) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/gallery/' . $filename;
    }

    protected function deleteImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
