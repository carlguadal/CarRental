@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Service Status</h2>
            
            <form action="{{ route('services.updateStatus', $service_reservation) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Status
                    </label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="pending" {{ $service_reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $service_reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $service_reservation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ $service_reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-pr-400 hover:bg-pr-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Status
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