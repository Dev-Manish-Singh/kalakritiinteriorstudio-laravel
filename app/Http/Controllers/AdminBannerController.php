<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBannerController extends Controller
{
    public function index(Request $request): View
    {
        $bannerItems = Banner::query()->latest('id')->get();

        $action = $request->string('action')->toString();
        $bannerId = $request->integer('banner');
        $selectedBanner = $bannerId ? Banner::findOrFail($bannerId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedBanner = null;
        }

        if (in_array($action, ['edit', 'view'], true) && ! $selectedBanner) {
            abort(404);
        }

        return view('backend.banners', [
            'bannerItems' => $bannerItems,
            'selectedBanner' => $selectedBanner,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['image_path'] = $this->storeImage($request);

        Banner::create($validated);

        return redirect()
            ->route('admin.banners', ['action' => 'create'])
            ->with('success', 'Banner added successfully.');
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $this->validatePayload($request, false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image_path);
            $validated['image_path'] = $this->storeImage($request);
        }

        $banner->update($validated);

        return redirect()
            ->route('admin.banners', ['action' => 'edit', 'banner' => $banner->id])
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->deleteImage($banner->image_path);
        $banner->delete();

        return redirect()
            ->route('admin.banners', ['action' => 'create'])
            ->with('success', 'Banner deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $banners = Banner::query()->whereIn('id', $validated['ids'])->get();

        foreach ($banners as $banner) {
            $this->deleteImage($banner->image_path);
            $banner->delete();
        }

        return redirect()
            ->route('admin.banners', ['action' => 'create'])
            ->with('success', 'Selected banners deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false): array
    {
        return $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'subheading' => ['required', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:255'],
            'button_link' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);
    }

    protected function storeImage(Request $request): string
    {
        $file = $request->file('image');
        $directory = public_path('uploads/banners');

        File::ensureDirectoryExists($directory);

        $filename = Str::slug($request->input('heading')) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/banners/' . $filename;
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
