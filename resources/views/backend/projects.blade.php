@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Projects')
@section('page_heading', 'Projects')
@section('content')
<style>
    .ia-project-title {
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ia-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: .4rem;
        flex-wrap: nowrap;
    }

    .ia-action-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .ia-action-icon em {
        font-size: 1rem;
        line-height: 1;
    }
</style>
@php
    $isView = $mode === 'view';
    $isEdit = $mode === 'edit';
    $formTitle = $isView ? 'View Project' : ($isEdit ? 'Edit Project' : 'Add New Project');
    $formAction = $isEdit && $selectedProject ? route('admin.projects.update', $selectedProject) : route('admin.projects.store');
@endphp

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bulkButton = document.querySelector('[data-bulk-delete-button]');
        const bulkForm = document.getElementById('projectBulkForm');

        if (!bulkButton || !bulkForm) {
            return;
        }

        bulkButton.addEventListener('click', function () {
            const selectedIds = Array.from(document.querySelectorAll('.ia-row-check:checked')).map((checkbox) => checkbox.value);

            if (!selectedIds.length) {
                alert('Please select at least one project.');
                return;
            }

            bulkForm.querySelectorAll('input[name="ids[]"]').forEach((input) => input.remove());
            selectedIds.forEach((id) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                bulkForm.appendChild(input);
            });

            if (confirm('Delete selected projects?')) {
                bulkForm.submit();
            }
        });
    });
</script>
@endpush

    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Project manager</p>
            <h2>Manage the frontend project listing and project detail pages from one place.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.projects', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <form action="{{ route('admin.projects.bulk-destroy') }}" method="post" id="projectBulkForm" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Project Cards</h3>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bulk-delete-button>
                            Delete Selected
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-middle ia-table datatable-init">
                            <thead>
                                <tr>
                                    <th class="tb-col tb-col-check" data-sortable="false">
                                        <div class="form-check">
                                            <input class="form-check-input ia-select-all" type="checkbox" value="">
                                        </div>
                                    </th>
                                    <th>Preview</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projectItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td class="ia-project-title" title="{{ $item->title }}">{{ $item->title }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="ia-action-group">
                                                <a class="btn btn-sm btn-outline-dark ia-action-icon" href="{{ route('admin.projects', ['action' => 'view', 'project' => $item->id]) }}" title="View" aria-label="View">
                                                    <em class="icon ni ni-eye"></em>
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary ia-action-icon" href="{{ route('admin.projects', ['action' => 'edit', 'project' => $item->id]) }}" title="Edit" aria-label="Edit">
                                                    <em class="icon ni ni-edit"></em>
                                                </a>
                                                <form action="{{ route('admin.projects.destroy', $item) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ia-action-icon" onclick="return confirm('Delete this project?')" title="Delete" aria-label="Delete">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No projects found yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">{{ strtoupper($mode) }}</p>
                            <h3>{{ $formTitle }}</h3>
                        </div>
                    </div>

                    <form action="{{ $formAction }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $selectedProject->title ?? '') }}" @disabled($isView) required>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $selectedProject->category ?? '') }}" @disabled($isView) required>
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label">Short Summary *</label>
                            <textarea class="form-control" id="summary" name="summary" rows="3" @disabled($isView) required>{{ old('summary', $selectedProject->summary ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Project Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="6" @disabled($isView) required>{{ old('description', $selectedProject->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="challenge_title" class="form-label">Challenge Title</label>
                            <input type="text" class="form-control" id="challenge_title" name="challenge_title" value="{{ old('challenge_title', $selectedProject->challenge_title ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="challenge_content" class="form-label">Challenge Content</label>
                            <textarea class="form-control" id="challenge_content" name="challenge_content" rows="5" @disabled($isView)>{{ old('challenge_content', $selectedProject->challenge_content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="quote_text" class="form-label">Quote Text</label>
                            <textarea class="form-control" id="quote_text" name="quote_text" rows="4" @disabled($isView)>{{ old('quote_text', $selectedProject->quote_text ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="quote_author" class="form-label">Quote Author</label>
                            <input type="text" class="form-control" id="quote_author" name="quote_author" value="{{ old('quote_author', $selectedProject->quote_author ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="final_title" class="form-label">Final View Title</label>
                            <input type="text" class="form-control" id="final_title" name="final_title" value="{{ old('final_title', $selectedProject->final_title ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="final_content" class="form-label">Final View Content</label>
                            <textarea class="form-control" id="final_content" name="final_content" rows="5" @disabled($isView)>{{ old('final_content', $selectedProject->final_content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Main Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView) {{ $isEdit ? '' : 'required' }}>
                            @if (! empty($selectedProject?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedProject->image_path) }}" alt="{{ $selectedProject->title }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="overlay_image" class="form-label">Overlay Image</label>
                            <input type="file" class="form-control" id="overlay_image" name="overlay_image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedProject?->overlay_image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedProject->overlay_image_path) }}" alt="{{ $selectedProject->title }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="secondary_image" class="form-label">Secondary Image</label>
                            <input type="file" class="form-control" id="secondary_image" name="secondary_image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedProject?->secondary_image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedProject->secondary_image_path) }}" alt="{{ $selectedProject->title }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="tertiary_image" class="form-label">Tertiary Image</label>
                            <input type="file" class="form-control" id="tertiary_image" name="tertiary_image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedProject?->tertiary_image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedProject->tertiary_image_path) }}" alt="{{ $selectedProject->title }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedProject->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedProject->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Project' : 'Save Project' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.projects', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
