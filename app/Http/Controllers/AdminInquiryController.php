<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInquiryController extends Controller
{
    public function index(): View
    {
        $inquiries = Inquiry::query()->latest()->get();

        return view('backend.inquiries', compact('inquiries'));
    }

    public function destroy(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()
            ->route('admin.inquiries')
            ->with('success', 'Inquiry deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        Inquiry::query()->whereIn('id', $validated['ids'])->delete();

        return redirect()
            ->route('admin.inquiries')
            ->with('success', 'Selected inquiries deleted successfully.');
    }
}
