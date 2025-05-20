@extends('layouts.myapp')

@section('content')
<div class="mx-auto max-w-lg bg-white rounded-md p-6 m-8 shadow">
    <h2 class="text-2xl font-bold mb-4">Down Payment for Reservation #{{ $reservation->id }}</h2>
    <p class="mb-2">Total Reservation Price: <span class="font-semibold">₱{{ number_format($reservation->total_price, 2) }}</span></p>
    <p class="mb-2">Down Payment Required (20%): <span class="font-semibold text-green-700">₱{{ number_format($reservation->total_price * 0.2, 2) }}</span></p>
    <p class="mb-6 text-gray-600">Click below to pay your down payment via GCash simulation.</p>

    @if(session('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="flex flex-col gap-4">
        <form action="{{ route('payment.gcash', $reservation) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Pay with GCash (Simulated)
            </button>
        </form>
    </div>
    <a href="{{ route('clientReservation') }}" class="block mt-6 text-center text-gray-500 hover:underline">Back to Reservations</a>
</div>
@endsection 