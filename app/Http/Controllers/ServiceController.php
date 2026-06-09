<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return view('frontend.service', compact('services'));
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        $services = Service::query()
            ->where('is_active', true)
            ->whereKeyNot($service->id)
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(4)
            ->get();

        return view('frontend.service-details', [
            'service' => $service,
            'services' => $services,
        ]);
    }
}
