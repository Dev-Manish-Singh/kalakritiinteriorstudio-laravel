@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Services')
@section('page_heading', 'Services')
@section('content')
<style>
    .ia-service-title {
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
    $formTitle = $isView ? 'View Service' : ($isEdit ? 'Edit Service' : 'Add New Service');
    $formAction = $isEdit && $selectedService ? route('admin.services.update', $selectedService) : route('admin.services.store');
@endphp

    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Service manager</p>
            <h2>Manage the frontend service cards and service detail pages from one place.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.services', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <form action="{{ route('admin.services.bulk-destroy') }}" method="post" id="serviceBulkForm">
                    @csrf
                    @method('DELETE')
                    <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Service Cards</h3>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete selected services?')">
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
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($serviceItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->icon_path) }}" alt="{{ $item->title }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td class="ia-service-title" title="{{ $item->title }}">{{ $item->title }}</td>
                                        <td>{{ $item->sort_order }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="ia-action-group">
                                                <a class="btn btn-sm btn-outline-dark ia-action-icon" href="{{ route('admin.services', ['action' => 'view', 'service' => $item->id]) }}" title="View" aria-label="View">
                                                    <em class="icon ni ni-eye"></em>
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary ia-action-icon" href="{{ route('admin.services', ['action' => 'edit', 'service' => $item->id]) }}" title="Edit" aria-label="Edit">
                                                    <em class="icon ni ni-edit"></em>
                                                </a>
                                                <form action="{{ route('admin.services.destroy', $item) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ia-action-icon" onclick="return confirm('Delete this service?')" title="Delete" aria-label="Delete">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No services found yet.</td>
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
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $selectedService->title ?? '') }}" @disabled($isView) required>
                            <div class="form-text">Service slug will be generated automatically.</div>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Short Description *</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3" @disabled($isView) required>{{ old('excerpt', $selectedService->excerpt ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Service Details *</label>
                            <textarea class="form-control" id="content" name="content" rows="6" @disabled($isView) required>{{ old('content', $selectedService->content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="highlights" class="form-label">What We Cover *</label>
                            <textarea class="form-control" id="highlights" name="highlights" rows="6" placeholder="One point per line" @disabled($isView) required>{{ old('highlights', $selectedService->highlights ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="process_content" class="form-label">How We Work *</label>
                            <textarea class="form-control" id="process_content" name="process_content" rows="5" @disabled($isView) required>{{ old('process_content', $selectedService->process_content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Card Icon *</label>
                            <input type="file" class="form-control" id="icon" name="icon" accept="image/*" @disabled($isView) {{ $isEdit ? '' : 'required' }}>
                            <div class="form-text">Use a square icon for the service listing card.</div>
                            @if (! empty($selectedService?->icon_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedService->icon_path) }}" alt="{{ $selectedService->title }}" style="width:90px;height:90px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Main Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView) {{ $isEdit ? '' : 'required' }}>
                            <div class="form-text">Shown as the large service image on the details page.</div>
                            @if (! empty($selectedService?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedService->image_path) }}" alt="{{ $selectedService->title }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="secondary_image" class="form-label">Secondary Image</label>
                            <input type="file" class="form-control" id="secondary_image" name="secondary_image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedService?->secondary_image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedService->secondary_image_path) }}" alt="{{ $selectedService->title }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="tertiary_image" class="form-label">Tertiary Image</label>
                            <input type="file" class="form-control" id="tertiary_image" name="tertiary_image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedService?->tertiary_image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedService->tertiary_image_path) }}" alt="{{ $selectedService->title }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedService->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedService->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Service' : 'Save Service' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.services', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
