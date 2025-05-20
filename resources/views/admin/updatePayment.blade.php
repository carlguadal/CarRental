@extends('layouts.myapp')
@section('content')
    <div class="container mx-auto py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-bold mb-6">Payment Status</h2>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Down Payment Status:</label>
                <span class="inline-block px-3 py-1 rounded-full text-white
                    @if($reservation->down_payment_status === 'paid') bg-green-500 @else bg-red-500 @endif">
                    {{ ucfirst($reservation->down_payment_status) }}
                </span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Final Payment Status:</label>
                <span class="inline-block px-3 py-1 rounded-full text-white
                    @if($reservation->final_payment_status === 'paid') bg-green-500 @else bg-red-500 @endif">
                    {{ ucfirst($reservation->final_payment_status) }}
                </span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Reservation Status:</label>
                <span class="inline-block px-3 py-1 rounded-full text-white
                    @if($reservation->status === 'Ended') bg-black @elseif($reservation->status === 'Active') bg-green-500 @elseif($reservation->status === 'Pending') bg-yellow-500 @else bg-red-500 @endif">
                    {{ ucfirst($reservation->status) }}
                </span>
            </div>
            <a href="{{ route('adminDashboard') }}" class="inline-block mt-6 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Dashboard</a>
        </div>
    </div>
@endsection
