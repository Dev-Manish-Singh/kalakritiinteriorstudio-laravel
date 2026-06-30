@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Gallery')
@section('page_heading', 'Gallery')
@section('content')
@php
    $isView = $mode === 'view';
    $isEdit = $mode === 'edit';
    $formTitle = $isView ? 'View Gallery Image' : ($isEdit ? 'Edit Gallery Image' : 'Add New Gallery Image');
    $formAction = $isEdit && $selectedGallery ? route('admin.gallery.update', $selectedGallery) : route('admin.gallery.store');
@endphp

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bulkButton = document.querySelector('[data-bulk-delete-button]');
        const bulkForm = document.getElementById('galleryBulkForm');

        if (!bulkButton || !bulkForm) {
            return;
        }

        bulkButton.addEventListener('click', function () {
            const selectedIds = Array.from(document.querySelectorAll('.ia-row-check:checked')).map((checkbox) => checkbox.value);

            if (!selectedIds.length) {
                alert('Please select at least one gallery image.');
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

            if (confirm('Delete selected gallery images?')) {
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
            <p class="ia-kicker">Gallery manager</p>
            <h2>Manage the gallery images that appear on the frontend gallery page.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.gallery', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <form action="{{ route('admin.gallery.bulk-destroy') }}" method="post" id="galleryBulkForm" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Gallery Images</h3>
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
                                    <th>Section</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($galleryItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->sort_order }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->updated_at?->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.gallery', ['action' => 'view', 'gallery' => $item->id]) }}">View</a>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.gallery', ['action' => 'edit', 'gallery' => $item->id]) }}">Edit</a>
                                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this gallery image?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No gallery images found yet.</td>
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
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $selectedGallery->title ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Section Label</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $selectedGallery->category ?? 'Gallery') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedGallery->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedGallery?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedGallery->image_path) }}" alt="{{ $selectedGallery->title }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedGallery->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Image' : 'Save Image' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.gallery', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
