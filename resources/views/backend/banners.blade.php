@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Banners')
@section('page_heading', 'Banner Management')
@section('content')
@php
    $isView = $mode === 'view';
    $isEdit = $mode === 'edit';
    $formTitle = $isView ? 'View Banner' : ($isEdit ? 'Edit Banner' : 'Add New Banner');
    $formAction = $isEdit && $selectedBanner ? route('admin.banners.update', $selectedBanner) : route('admin.banners.store');
@endphp

    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Banner manager</p>
            <h2>Manage the hero banners used on the frontend home page.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.banners', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <form action="{{ route('admin.banners.bulk-destroy') }}" method="post" id="bannerBulkForm">
                    @csrf
                    @method('DELETE')
                    <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Banner Slides</h3>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete selected banners?')">
                                Delete Selected
                            </button>
                        </div>
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
                                    <th>Heading</th>
                                    <th>Button</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bannerItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->heading }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td>{{ $item->heading }}</td>
                                        <td>{{ $item->button_text }}</td>
                                        <td>{{ $item->sort_order }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.banners', ['action' => 'view', 'banner' => $item->id]) }}">View</a>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.banners', ['action' => 'edit', 'banner' => $item->id]) }}">Edit</a>
                                            <form action="{{ route('admin.banners.destroy', $item) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this banner?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No banners found yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    </div>
                </form>
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
                            <label for="heading" class="form-label">Heading</label>
                            <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $selectedBanner->heading ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="subheading" class="form-label">Subheading</label>
                            <textarea class="form-control" id="subheading" name="subheading" rows="4" @disabled($isView)>{{ old('subheading', $selectedBanner->subheading ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="button_text" name="button_text" value="{{ old('button_text', $selectedBanner->button_text ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="button_link" class="form-label">Button Link</label>
                            <input type="text" class="form-control" id="button_link" name="button_link" value="{{ old('button_link', $selectedBanner->button_link ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedBanner->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Background Image</label>
                            <div class="form-text">Recommended size: 1229 × 887 px</div>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedBanner?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedBanner->image_path) }}" alt="{{ $selectedBanner->heading }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedBanner->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Banner' : 'Save Banner' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.banners', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
