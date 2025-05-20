@extends('layouts.myapp')

@section('content')
<div class="mx-auto max-w-lg bg-white rounded-md p-6 m-8 shadow text-center">
    <h2 class="text-2xl font-bold mb-4">GCash Payment Simulation</h2>
    <p class="mb-4">This is a fake GCash payment page for demo/testing purposes.</p>
    <div class="mb-6">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/GCash_logo.png" alt="GCash Logo" class="mx-auto h-20 mb-4">
        <p class="text-lg">Reservation #{{ $reservation->id }}</p>
        <p class="text-xl font-semibold">Amount: ₱{{ number_format($reservation->down_payment_amount, 2) }}</p>
    </div>
    <form action="{{ route('payment.gcash.confirm', $reservation) }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded mb-2">
            Simulate Payment Success
        </button>
    </form>
    <a href="{{ route('clientReservation') }}" class="block mt-4 text-gray-500 hover:underline">Cancel / Back to Reservations</a>
</div>
@endsection 