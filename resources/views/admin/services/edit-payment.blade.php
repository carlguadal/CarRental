@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Payment Status</h2>
            
            <form action="{{ route('services.updatePayment', $service_reservation) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_status">
                        Payment Status
                    </label>
                    <select name="payment_status" id="payment_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="unpaid" {{ $service_reservation->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $service_reservation->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-pr-400 hover:bg-pr-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Payment Status
                    </button>
                    <a href="{{ route('adminDashboard') }}" class="text-pr-400 hover:text-pr-500 font-bold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 