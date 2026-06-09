<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminServiceController extends Controller
{
    public function index(Request $request): View
    {
        $serviceItems = Service::query()->latest('id')->get();

        $action = $request->string('action')->toString();
        $serviceId = $request->integer('service');
        $selectedService = $serviceId ? Service::findOrFail($serviceId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedService = null;
        }

        if (in_array($action, ['edit', 'view'], true) && ! $selectedService) {
            abort(404);
        }

        return view('backend.services', [
            'serviceItems' => $serviceItems,
            'selectedService' => $selectedService,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['icon_path'] = $this->storeImage($request, 'icon', 'uploads/services/icons');
        $validated['image_path'] = $this->storeOptionalImage($request, 'image', 'uploads/services');
        $validated['secondary_image_path'] = $this->storeOptionalImage($request, 'secondary_image', 'uploads/services');
        $validated['tertiary_image_path'] = $this->storeOptionalImage($request, 'tertiary_image', 'uploads/services');

        Service::create($validated);

        return redirect()
            ->route('admin.services', ['action' => 'create'])
            ->with('success', 'Service added successfully.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validatePayload($request, false, $service->id);
        $validated['slug'] = $this->uniqueSlug($validated['title'], $service->id);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            $this->deleteImage($service->icon_path);
            $validated['icon_path'] = $this->storeImage($request, 'icon', 'uploads/services/icons');
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($service->image_path);
            $validated['image_path'] = $this->storeOptionalImage($request, 'image', 'uploads/services');
        }

        if ($request->hasFile('secondary_image')) {
            $this->deleteImage($service->secondary_image_path);
            $validated['secondary_image_path'] = $this->storeOptionalImage($request, 'secondary_image', 'uploads/services');
        }

        if ($request->hasFile('tertiary_image')) {
            $this->deleteImage($service->tertiary_image_path);
            $validated['tertiary_image_path'] = $this->storeOptionalImage($request, 'tertiary_image', 'uploads/services');
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services', ['action' => 'edit', 'service' => $service->id])
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteImage($service->icon_path);
        $this->deleteImage($service->image_path);
        $this->deleteImage($service->secondary_image_path);
        $this->deleteImage($service->tertiary_image_path);
        $service->delete();

        return redirect()
            ->route('admin.services', ['action' => 'create'])
            ->with('success', 'Service deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $services = Service::query()->whereIn('id', $validated['ids'])->get();

        foreach ($services as $service) {
            $this->deleteImage($service->icon_path);
            $this->deleteImage($service->image_path);
            $this->deleteImage($service->secondary_image_path);
            $this->deleteImage($service->tertiary_image_path);
            $service->delete();
        }

        return redirect()
            ->route('admin.services', ['action' => 'create'])
            ->with('success', 'Selected services deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'title')->ignore($ignoreId),
            ],
            'excerpt' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'highlights' => ['required', 'string'],
            'process_content' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'icon' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
            'image' => ['nullable', 'image', 'max:5120'],
            'secondary_image' => ['nullable', 'image', 'max:5120'],
            'tertiary_image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $count = 1;

        while (
            Service::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    protected function storeImage(Request $request, string $field, string $directory): string
    {
        $file = $request->file($field);
        $fullDirectory = public_path($directory);

        File::ensureDirectoryExists($fullDirectory);

        $filename = Str::slug($request->input('title')) . '_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($fullDirectory, $filename);

        return $directory . '/' . $filename;
    }

    protected function storeOptionalImage(Request $request, string $field, string $directory): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $this->storeImage($request, $field, $directory);
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
