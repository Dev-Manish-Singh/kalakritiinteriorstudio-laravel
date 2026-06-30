@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Testimonials')
@section('page_heading', 'Testimonials')
@section('content')
<style>
    .ia-testimonial-title {
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
    $formTitle = $isView ? 'View Testimonial' : ($isEdit ? 'Edit Testimonial' : 'Add New Testimonial');
    $formAction = $isEdit && $selectedTestimonial ? route('admin.testimonials.update', $selectedTestimonial) : route('admin.testimonials.store');
@endphp

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bulkButton = document.querySelector('[data-bulk-delete-button]');
        const bulkForm = document.getElementById('testimonialBulkForm');

        if (!bulkButton || !bulkForm) {
            return;
        }

        bulkButton.addEventListener('click', function () {
            const selectedIds = Array.from(document.querySelectorAll('.ia-row-check:checked')).map((checkbox) => checkbox.value);

            if (!selectedIds.length) {
                alert('Please select at least one testimonial.');
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

            if (confirm('Delete selected testimonials?')) {
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
            <p class="ia-kicker">Testimonial manager</p>
            <h2>Manage home page testimonials from the admin panel.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.testimonials', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <div class="card-body">
                    <form action="{{ route('admin.testimonials.bulk-destroy') }}" method="post" id="testimonialBulkForm" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Testimonials</h3>
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
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonialItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td class="ia-testimonial-title" title="{{ $item->name }}">{{ $item->name }}</td>
                                        <td>{{ $item->designation }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="ia-action-group">
                                                <a class="btn btn-sm btn-outline-dark ia-action-icon" href="{{ route('admin.testimonials', ['action' => 'view', 'testimonial' => $item->id]) }}" title="View" aria-label="View"><em class="icon ni ni-eye"></em></a>
                                                <a class="btn btn-sm btn-outline-primary ia-action-icon" href="{{ route('admin.testimonials', ['action' => 'edit', 'testimonial' => $item->id]) }}" title="Edit" aria-label="Edit"><em class="icon ni ni-edit"></em></a>
                                                <form action="{{ route('admin.testimonials.destroy', $item) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ia-action-icon" onclick="return confirm('Delete this testimonial?')" title="Delete" aria-label="Delete"><em class="icon ni ni-trash"></em></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No testimonials found yet.</td>
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
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $selectedTestimonial->name ?? '') }}" @disabled($isView) required>
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation *</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $selectedTestimonial->designation ?? '') }}" @disabled($isView) required>
                        </div>

                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $selectedTestimonial->company ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback *</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="6" @disabled($isView) required>{{ old('feedback', $selectedTestimonial->feedback ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView) {{ $isEdit ? '' : 'required' }}>
                            @if (! empty($selectedTestimonial?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedTestimonial->image_path) }}" alt="{{ $selectedTestimonial->name }}" style="width:100%;max-height:200px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="quote_icon" class="form-label">Quote Icon</label>
                            <input type="file" class="form-control" id="quote_icon" name="quote_icon" accept="image/*" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedTestimonial->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedTestimonial->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Testimonial' : 'Save Testimonial' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.testimonials', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
