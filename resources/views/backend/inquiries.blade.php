@extends('backend.master.admin')
@section('title', 'Interior Studio Admin - Inquiries')
@section('page_heading', 'Inquiries')
@section('content')
    <section class="ia-hero">
        <div>
            <p class="ia-kicker">Inquiry manager</p>
            <h2>View contact form submissions from the frontend website.</h2>
        </div>
    </section>

    <div class="card ia-card">
        <form action="{{ route('admin.inquiries.bulk-destroy') }}" method="post" id="inquiryBulkForm">
            @csrf
            @method('DELETE')
            <div class="card-body">
                <div class="ia-section-head mb-3">
                    <div>
                        <p class="ia-kicker">Listing</p>
                        <h3>Contact Inquiries</h3>
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete selected inquiries?')">
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inquiries as $inquiry)
                                <tr>
                                    <td class="tb-col tb-col-check">
                                        <div class="form-check">
                                            <input class="form-check-input ia-row-check" type="checkbox" name="ids[]" value="{{ $inquiry->id }}">
                                        </div>
                                    </td>
                                    <td>{{ $inquiry->name }}</td>
                                    <td>{{ $inquiry->email }}</td>
                                    <td>{{ $inquiry->phone }}</td>
                                    <td style="max-width:360px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $inquiry->message }}">{{ $inquiry->message }}</td>
                                    <td><span class="ia-badge {{ $inquiry->status === 'new' ? 'active' : 'draft' }}">{{ ucfirst($inquiry->status) }}</span></td>
                                    <td>{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this inquiry?')">
                                                <em class="icon ni ni-trash"></em>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No inquiries received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
