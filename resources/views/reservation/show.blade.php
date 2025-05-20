@extends('layouts.myapp')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-md p-6 mt-8">
    <h2 class="text-2xl font-bold mb-4">Reservation Details</h2>
    <div class="mb-4">
        <strong>Car:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }} ({{ $reservation->car->engine }})
    </div>
    <div class="mb-2">
        <strong>From:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') }}
    </div>
    <div class="mb-2">
        <strong>To:</strong> {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') }}
    </div>
    <div class="mb-2">
        <strong>Price per day:</strong> ₱{{ $reservation->price_per_day }}
    </div>
    <div class="mb-2">
        <strong>Total price:</strong> ₱{{ $reservation->total_price }}
    </div>
    <div class="mb-2">
        <strong>Status:</strong> {{ $reservation->status }}
    </div>
    <div class="mb-2">
        <strong>Payment status:</strong> {{ $reservation->payment_status }}
    </div>
    <a href="{{ route('clientReservation') }}" class="inline-block mt-4 bg-pr-400 text-white px-4 py-2 rounded hover:bg-pr-500">Back to My Reservations</a>
</div>
@endsection 