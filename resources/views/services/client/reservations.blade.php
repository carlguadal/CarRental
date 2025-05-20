@extends('layouts.myapp')

@section('content')
<div class="mx-auto max-w-screen-xl bg-white rounded-md p-6 m-8">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">My Service Reservations</h2>
        <p class="mt-2 text-gray-600">View and manage your service appointments</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">You don't have any service reservations yet.</p>
            <a href="{{ route('client.services.index') }}" class="mt-4 inline-block bg-pr-400 text-white px-6 py-2 rounded-md hover:bg-pr-500 transition duration-150">
                Browse Services
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $reservation->service->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($reservation->service->price, 2) }} ₱
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $reservation->scheduled_date->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $reservation->scheduled_date->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($reservation->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($reservation->status == 'approved') bg-green-100 text-green-800
                                    @elseif($reservation->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($reservation->payment_status == 'paid') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($reservation->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs overflow-hidden">
                                    {{ $reservation->notes ?? 'No notes' }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 