<?php

namespace App\Http\Controllers;

use App\Models\ServiceReservation;
use Illuminate\Http\Request;

class ServiceReservationsController extends Controller
{
    public function editStatus(ServiceReservation $service_reservation)
    {
        return view('admin.services.edit-status', compact('service_reservation'));
    }

    public function updateStatus(Request $request, ServiceReservation $service_reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $service_reservation->update([
            'status' => $request->status
        ]);

        return redirect()->route('adminDashboard')
            ->with('success', 'Service reservation status updated successfully.');
    }

    public function editPayment(ServiceReservation $service_reservation)
    {
        return view('admin.services.edit-payment', compact('service_reservation'));
    }

    public function updatePayment(Request $request, ServiceReservation $service_reservation)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid'
        ]);

        $service_reservation->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->route('adminDashboard')
            ->with('success', 'Service reservation payment status updated successfully.');
    }
} 