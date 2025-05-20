<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Show payment options for a reservation
    public function showDownPaymentForm(Reservation $reservation)
    {
        // Always set down payment to 20% of total price
        $reservation->down_payment_amount = round($reservation->total_price * 0.2, 2);
        $reservation->save();
        return view('payments.down_payment', compact('reservation'));
    }

    // Show fake GCash confirmation page
    public function payWithGCash(Request $request, Reservation $reservation)
    {
        // Always set down payment to 20% of total price
        $reservation->down_payment_amount = round($reservation->total_price * 0.2, 2);
        $reservation->save();
        return view('payments.fake_gcash', compact('reservation'));
    }

    // Handle fake GCash payment confirmation
    public function confirmFakeGCash(Request $request, Reservation $reservation)
    {
        $reservation->down_payment_status = 'paid';
        $reservation->save();
        return redirect()->route('clientReservation')->with('success', 'Down payment marked as paid (GCash simulation).');
    }

    // GCash success callback
    public function gcashSuccess(Request $request, Reservation $reservation)
    {
        // In production, verify payment via webhook or API
        $reservation->down_payment_status = 'paid';
        $reservation->save();
        return redirect()->route('clientReservation')->with('success', 'Down payment successful via GCash!');
    }

    // GCash cancel callback
    public function gcashCancel(Reservation $reservation)
    {
        return redirect()->route('clientReservation')->with('error', 'GCash payment was cancelled.');
    }

    // Show fake final payment page
    public function showFinalPaymentForm(Reservation $reservation)
    {
        // Set final payment to 80% of total price
        $reservation->final_payment_amount = round($reservation->total_price * 0.8, 2);
        $reservation->save();
        return view('payments.fake_final', compact('reservation'));
    }

    // Handle fake final payment confirmation
    public function confirmFakeFinalPayment(Request $request, Reservation $reservation)
    {
        $reservation->final_payment_status = 'paid';
        $reservation->save();
        return redirect()->route('clientReservation')->with('success', 'Final payment marked as paid (simulation).');
    }

    // Simulate car return
    public function returnCar(Request $request, Reservation $reservation)
    {
        $reservation->status = 'Ended';
        $reservation->returned_at = now();
        $reservation->save();
        return redirect()->route('clientReservation')->with('success', 'Car marked as returned.');
    }
} 