@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Blogs')
@section('page_heading', 'Blogs')
@section('content')
<style>
    .ia-blog-title {
        max-width: 360px;
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
    $formTitle = $isView ? 'View Blog' : ($isEdit ? 'Edit Blog' : 'Add New Blog');
    $formAction = $isEdit && $selectedBlog ? route('admin.blogs.update', $selectedBlog) : route('admin.blogs.store');
@endphp

    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Blog manager</p>
            <h2>Manage blog posts that appear on the frontend blog listing and detail pages.</h2>
        </div>
        <a class="btn ia-btn-gold" href="{{ route('admin.blogs', ['action' => 'create']) }}">
            <em class="icon ni ni-plus"></em><span>Add New</span>
        </a>
    </section>

    <section class="row g-gs">
        <div class="col-xl-8">
            <div class="card ia-card h-100">
                <form action="{{ route('admin.blogs.bulk-destroy') }}" method="post" id="blogBulkForm">
                    @csrf
                    @method('DELETE')
                    <div class="card-body">
                    <div class="ia-section-head">
                        <div>
                            <p class="ia-kicker">Listing</p>
                            <h3>Blog Posts</h3>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete selected blogs?')">
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
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogItems as $item)
                                    <tr>
                                        <td class="tb-col tb-col-check">
                                            <div class="form-check">
                                                <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                                        </td>
                                        <td class="ia-blog-title" title="{{ $item->title }}">{{ $item->title }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ optional($item->published_at)->format('d M Y') }}</td>
                                        <td>
                                            <span class="ia-badge {{ $item->is_active ? 'active' : 'draft' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="ia-action-group">
                                                <a class="btn btn-sm btn-outline-dark ia-action-icon" href="{{ route('admin.blogs', ['action' => 'view', 'blog' => $item->id]) }}" title="View" aria-label="View">
                                                    <em class="icon ni ni-eye"></em>
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary ia-action-icon" href="{{ route('admin.blogs', ['action' => 'edit', 'blog' => $item->id]) }}" title="Edit" aria-label="Edit">
                                                    <em class="icon ni ni-edit"></em>
                                                </a>
                                                <form action="{{ route('admin.blogs.destroy', $item) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ia-action-icon" onclick="return confirm('Delete this blog?')" title="Delete" aria-label="Delete">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No blog posts found yet.</td>
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
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $selectedBlog->title ?? '') }}" @disabled($isView)>
                            <div class="form-text">Slug will be generated automatically from the title.</div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $selectedBlog->category ?? '') }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3" @disabled($isView)>{{ old('excerpt', $selectedBlog->excerpt ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="8" @disabled($isView)>{{ old('content', $selectedBlog->content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', $selectedBlog->tags ?? '') }}" placeholder="e.g. kitchen, modular, interior" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Published Date</label>
                            <input type="date" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', optional($selectedBlog?->published_at)->format('Y-m-d')) }}" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $selectedBlog->sort_order ?? 0) }}" min="0" @disabled($isView)>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Feature Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" @disabled($isView)>
                            @if (! empty($selectedBlog?->image_path))
                                <div class="mt-3">
                                    <img src="{{ asset($selectedBlog->image_path) }}" alt="{{ $selectedBlog->title }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:16px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', $selectedBlog->is_active ?? true)) @disabled($isView)>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if (! $isView)
                                <button class="btn ia-btn-gold" type="submit">
                                    <em class="icon ni ni-save"></em>
                                    <span>{{ $isEdit ? 'Update Blog' : 'Save Blog' }}</span>
                                </button>
                            @endif
                            <a class="btn btn-outline-dark" href="{{ route('admin.blogs', ['action' => 'create']) }}">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
