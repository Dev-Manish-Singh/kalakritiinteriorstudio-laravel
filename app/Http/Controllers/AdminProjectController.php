<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projectItems = Project::query()->latest('id')->get();

        $action = $request->string('action')->toString();
        $projectId = $request->integer('project');
        $selectedProject = $projectId ? Project::findOrFail($projectId) : null;

        if (! in_array($action, ['create', 'edit', 'view'], true)) {
            $action = 'create';
            $selectedProject = null;
        }

        if (in_array($action, ['edit', 'view'], true) && ! $selectedProject) {
            abort(404);
        }

        return view('backend.projects', [
            'projectItems' => $projectItems,
            'selectedProject' => $selectedProject,
            'mode' => $action,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, true);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['image_path'] = $this->storeImage($request, 'image', 'uploads/projects');
        $validated['secondary_image_path'] = $this->storeOptionalImage($request, 'secondary_image', 'uploads/projects');
        $validated['tertiary_image_path'] = $this->storeOptionalImage($request, 'tertiary_image', 'uploads/projects');
        $validated['overlay_image_path'] = $this->storeOptionalImage($request, 'overlay_image', 'uploads/projects');

        Project::create($validated);

        return redirect()
            ->route('admin.projects', ['action' => 'create'])
            ->with('success', 'Project added successfully.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validatePayload($request, false, $project->id);
        $validated['slug'] = $this->uniqueSlug($validated['title'], $project->id);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($project->image_path);
            $validated['image_path'] = $this->storeImage($request, 'image', 'uploads/projects');
        }

        if ($request->hasFile('secondary_image')) {
            $this->deleteImage($project->secondary_image_path);
            $validated['secondary_image_path'] = $this->storeOptionalImage($request, 'secondary_image', 'uploads/projects');
        }

        if ($request->hasFile('tertiary_image')) {
            $this->deleteImage($project->tertiary_image_path);
            $validated['tertiary_image_path'] = $this->storeOptionalImage($request, 'tertiary_image', 'uploads/projects');
        }

        if ($request->hasFile('overlay_image')) {
            $this->deleteImage($project->overlay_image_path);
            $validated['overlay_image_path'] = $this->storeOptionalImage($request, 'overlay_image', 'uploads/projects');
        }

        $project->update($validated);

        return redirect()
            ->route('admin.projects', ['action' => 'edit', 'project' => $project->id])
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteImage($project->image_path);
        $this->deleteImage($project->secondary_image_path);
        $this->deleteImage($project->tertiary_image_path);
        $this->deleteImage($project->overlay_image_path);
        $project->delete();

        return redirect()
            ->route('admin.projects', ['action' => 'create'])
            ->with('success', 'Project deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $projects = Project::query()->whereIn('id', $validated['ids'])->get();

        foreach ($projects as $project) {
            $this->deleteImage($project->image_path);
            $this->deleteImage($project->secondary_image_path);
            $this->deleteImage($project->tertiary_image_path);
            $this->deleteImage($project->overlay_image_path);
            $project->delete();
        }

        return redirect()
            ->route('admin.projects', ['action' => 'create'])
            ->with('success', 'Selected projects deleted successfully.');
    }

    protected function validatePayload(Request $request, bool $isCreate = false, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'title')->ignore($ignoreId),
            ],
            'category' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['required', 'string'],
            'challenge_title' => ['nullable', 'string', 'max:255'],
            'challenge_content' => ['nullable', 'string'],
            'quote_text' => ['nullable', 'string'],
            'quote_author' => ['nullable', 'string', 'max:255'],
            'final_title' => ['nullable', 'string', 'max:255'],
            'final_content' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$isCreate ? 'required' : 'nullable', 'image', 'max:5120'],
            'secondary_image' => ['nullable', 'image', 'max:5120'],
            'tertiary_image' => ['nullable', 'image', 'max:5120'],
            'overlay_image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $count = 1;

        while (
            Project::query()
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
