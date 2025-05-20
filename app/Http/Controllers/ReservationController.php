<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Car $car)
    {
        $user = auth()->user();
        return view('reservation.create', compact('car', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $car_id)
    {
        $request->validate([
            'full-name' => 'required|string|max:255',
            'email' => 'required|email',
            'reservation_dates' => 'required|string',
            'drivers_license' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        $car = Car::find($car_id);
        $user = Auth::user();

        // Check if the user has more than 2 reservations
        $userReservationsCount = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['Pending', 'Active'])
            ->count();
            
        if ($userReservationsCount >= 2) {
            return redirect()->back()->with('error', 'You cannot have more than 2 active reservations 😉.');
        }

        // Extract start and end dates from the reservation_dates input
        $reservation_dates = explode(' to ', $request->reservation_dates);

        // Validate that both start and end dates are present
        if (count($reservation_dates) !== 2) {
            return redirect()->back()->with('error', 'Invalid reservation dates format. Please select a valid date range.');
        }

        // Parse dates using Carbon
        $start = Carbon::parse($reservation_dates[0])->startOfDay();
        $end = Carbon::parse($reservation_dates[1])->endOfDay();

        // Validate dates
        if ($start < Carbon::today()) {
            return redirect()->back()->with('error', 'Start date cannot be in the past.');
        }

        if ($end < $start) {
            return redirect()->back()->with('error', 'End date must be after start date.');
        }

        // Check if car is available for these dates
        $conflictingReservation = Reservation::where('car_id', $car_id)
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $end);
                    });
            })
            ->whereIn('status', ['Pending', 'Active'])
            ->first();

        if ($conflictingReservation) {
            return redirect()->back()->with('error', 'Car is not available for the selected dates.');
        }

        // Calculate days including both start and end dates
        $days = $start->diffInDays($end) + 1;

        // Create a new reservation
        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $reservation->car()->associate($car);
        $reservation->start_date = $start;
        $reservation->end_date = $end;
        $reservation->days = $days;
        $reservation->price_per_day = $car->price_per_day;
        $reservation->total_price = $days * $car->price_per_day;
        $reservation->status = 'Pending';
        $reservation->payment_method = 'At store';
        $reservation->payment_status = 'Pending';

        // Handle driver's license upload
        if ($request->hasFile('drivers_license')) {
            $file = $request->file('drivers_license');
            $filename = 'license_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/licenses', $filename);
            $reservation->drivers_license = $path;
        }

        $reservation->save();

        // Update the car's status to Reserved
        $car->status = 'Reserved';
        $car->save();

        return redirect()->route('clientReservation')->with('success', 'Car reserved successfully! 🚗 You can view your reservation details in your dashboard.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    // Edit and Update Payment status
    public function editPayment(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updatePayment', compact('reservation'));
    }

    public function updatePayment(Reservation $reservation, Request $request)
    {
        $reservation->down_payment_status = $request->down_payment_status;
        $reservation->final_payment_status = $request->final_payment_status;
        $reservation->save();
        return redirect()->route('adminDashboard')->with('success', 'Payment statuses updated successfully.');
    }

    // Edit and Update Reservation Status
    public function editStatus(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updateStatus', compact('reservation'));
    }

    public function updateStatus(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->status = $request->status;
        $car = $reservation->car;
        if($request->status == 'Ended' || $request->status == 'Canceled' ){
            $car->status = 'Available';
            $car->save();
        }
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    /**
     * Check if a car is available for the given dates
     */
    public function checkAvailability(Car $car, Request $request)
    {
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        $conflictingReservation = Reservation::where('car_id', $car->id)
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $end);
                    });
            })
            ->whereIn('status', ['Pending', 'Active'])
            ->first();

        return response()->json([
            'available' => !$conflictingReservation,
            'message' => $conflictingReservation ? 'Car is not available for these dates' : 'Car is available for these dates'
        ]);
    }
}
