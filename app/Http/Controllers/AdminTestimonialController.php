<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminTestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $testimonialItems = Testimonial::query()->latest('id')->get();

        $action = $request->string('action')->toString();
        $testimonialId = $request->integer('testimonial');
        $selectedTestimonial = $testimonialId ? Testimonial::findOrFail($testimonialId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedTestimonial = null;
        }

        if (in_array($action, ['edit', 'view'], true) && ! $selectedTestimonial) {
            abort(404);
        }

        return view('backend.testimonials', [
            'testimonialItems' => $testimonialItems,
            'selectedTestimonial' => $selectedTestimonial,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['image_path'] = $this->storeImage($request, 'image', 'uploads/testimonials');
        $validated['quote_icon_path'] = $this->storeOptionalImage($request, 'quote_icon', 'uploads/testimonials');

        Testimonial::create($validated);

        return redirect()
            ->route('admin.testimonials', ['action' => 'create'])
            ->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validatePayload($request, false, $testimonial->id);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $testimonial->id);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($testimonial->image_path);
            $validated['image_path'] = $this->storeImage($request, 'image', 'uploads/testimonials');
        }

        if ($request->hasFile('quote_icon')) {
            $this->deleteImage($testimonial->quote_icon_path);
            $validated['quote_icon_path'] = $this->storeOptionalImage($request, 'quote_icon', 'uploads/testimonials');
        }

        $testimonial->update($validated);

        return redirect()
            ->route('admin.testimonials', ['action' => 'edit', 'testimonial' => $testimonial->id])
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteImage($testimonial->image_path);
        $this->deleteImage($testimonial->quote_icon_path);
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials', ['action' => 'create'])
            ->with('success', 'Testimonial deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $testimonials = Testimonial::query()->whereIn('id', $validated['ids'])->get();

        foreach ($testimonials as $testimonial) {
            $this->deleteImage($testimonial->image_path);
            $this->deleteImage($testimonial->quote_icon_path);
            $testimonial->delete();
        }

        return redirect()
            ->route('admin.testimonials', ['action' => 'create'])
            ->with('success', 'Selected testimonials deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('testimonials', 'name')->ignore($ignoreId),
            ],
            'designation' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'feedback' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
            'quote_icon' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $count = 1;

        while (
            Testimonial::query()
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
        $fullDirectory = base_path('../public_html/' . $directory);

        File::ensureDirectoryExists($fullDirectory);

        $filename = Str::slug($request->input('name')) . '_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();
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

        $fullPath = base_path('../public_html/' . $path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
