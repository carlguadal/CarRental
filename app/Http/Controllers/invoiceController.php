<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class InvoiceController extends Controller
{
    public function invoice($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        $tax = $reservation->total_price * 0.15;
        $total = $reservation->total_price + $tax;
        return view('invoice', compact('reservation', 'tax', 'total'));
    }
}
