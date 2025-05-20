<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientServicesController extends Controller
{
    public function index()
    {
        $query = Service::query();

        if (request('search')) {
            $query->where('servicename', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
        }

        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $services = $query->paginate(9);
        return view('services.client.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.client.show', compact('service'));
    }

    public function reserve(Service $service, Request $request)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500'
        ]);

        ServiceReservation::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'scheduled_date' => $request->scheduled_date,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        return redirect()->route('client.services.reservations')
            ->with('success', 'Service reservation submitted successfully!');
    }

    public function myReservations()
    {
        $reservations = ServiceReservation::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('services.client.reservations', compact('reservations'));
    }
} 