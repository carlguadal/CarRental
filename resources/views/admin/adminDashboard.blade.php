@extends('layouts.admin')

@section('content')
    <div class="flex justify-center min-h-screen bg-sec-400">
        <div class="w-10/12 py-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">
                    Dashboard
                </h2>

                <!-- Cards -->
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Total Clients Card -->
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-200">
                        <div class="p-3 mr-4 text-white bg-pr-400 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Total clients
                            </p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $totalUsers }} (admins: {{ $admins ?? 0 }})
                            </p>
                        </div>
                    </div>

                    <!-- Available Cars Card -->
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-200">
                        <div class="p-3 mr-4 text-white bg-pr-400 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Available Cars
                            </p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $availableCars }}
                            </p>
                        </div>
                    </div>

                    <!-- Active Reservations Card -->
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-200">
                        <div class="p-3 mr-4 text-white bg-pr-400 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M184 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H96c-35.3 0-64 28.7-64 64v16 48V448c0 35.3 28.7 64 64 64H416c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H376V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H184V24zM80 192H432V448c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V192zm176 40c-13.3 0-24 10.7-24 24v48H184c-13.3 0-24 10.7-24 24s10.7 24 24 24h48v48c0 13.3 10.7 24 24 24s24-10.7 24-24V352h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V256c0-13.3-10.7-24-24-24z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Active Reservations
                            </p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $activeReservations ?? 0 }}
                            </p>
                        </div>
                    </div>

                    <!-- Available Services Card -->
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-200">
                        <div class="p-3 mr-4 text-white bg-pr-400 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M224 80c0-26.5 21.5-48 48-48h16c26.5 0 48 21.5 48 48v16h24c26.5 0 48 21.5 48 48v16.8c0 19.4-13.7 36.2-32.7 40.1l-91.9 18.4c-4.9 1-8.4 5.3-8.4 10.3V288h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V352c0-35.3 28.7-64 64-64h64V240.2L183.3 216c-16.6-4.2-28.2-19.1-28.2-36.2V144c0-26.5 21.5-48 48-48h24V80z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Available Services
                            </p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $availableServices ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reservations Table -->
                <div class="mt-12">
                    <div class="flex items-center justify-center mb-6">
                        <hr class="flex-1 h-0.5 bg-pr-400">
                        <h3 class="px-4 font-car font-bold text-gray-600 text-xl">RESERVATIONS</h3>
                        <hr class="flex-1 h-0.5 bg-pr-400">
                    </div>
                </div>

                <div class="w-full overflow-hidden rounded-lg shadow-xs border border-gray-200">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">CLIENT</th>
                                    <th class="px-4 py-3">CAR</th>
                                    <th class="px-4 py-3">STARTED AT</th>
                                    <th class="px-4 py-3">END AT</th>
                                    <th class="px-4 py-3">DURATION</th>
                                    <th class="px-4 py-3">REMAINING DAYS</th>
                                    <th class="px-4 py-3">PRICE</th>
                                    <th class="px-4 py-3">PAYMENT STATUS</th>
                                    <th class="px-4 py-3">STATUS</th>
                                    <th class="px-4 py-3">Return Status</th>
                                    <th class="px-4 py-3">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse($recentReservations as $reservation)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full" 
                                                     src="{{ $reservation->user->avatar ?? '/images/user.png' }}" 
                                                     alt="" loading="lazy">
                                            </div>
                                            <div>
                                                @if($reservation->user)
                                                    <p class="font-semibold">{{ $reservation->user->name }}</p>
                                                    <p class="text-xs text-gray-600">{{ $reservation->user->email }}</p>
                                                @else
                                                    <p class="font-semibold text-red-500">[User Deleted]</p>
                                                    <p class="text-xs text-gray-600">-</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $reservation->car->brand }} {{ $reservation->car->model }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->start_date)->format('y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->format('y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::parse($reservation->start_date)) }} days
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($reservation->start_date > Carbon\Carbon::now())
                                            {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::now()) }} days
                                        @else
                                            {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::now()) }} days
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        ₱{{ $reservation->total_price }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 font-semibold leading-tight rounded-md
                                            {{ $reservation->payment_status == 'Pending' ? 'bg-yellow-300 text-white' : 
                                               ($reservation->payment_status == 'Canceled' ? 'bg-red-500 text-white' : 
                                               'bg-green-500 text-white px-5') }}">
                                            {{ $reservation->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 font-semibold leading-tight rounded-md
                                            {{ $reservation->status == 'Pending' ? 'bg-yellow-300 text-white' : 
                                               ($reservation->status == 'Ended' ? 'bg-black text-white' : 
                                               ($reservation->status == 'Active' ? 'bg-green-500 text-white px-4' : 
                                               'bg-red-500 text-white')) }}">
                                            {{ $reservation->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($reservation->returned_at)
                                            <span class="px-2 py-1 font-semibold leading-tight rounded-md bg-green-100 text-green-800">
                                                Returned: {{ \Carbon\Carbon::parse($reservation->returned_at)->format('Y-m-d') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight rounded-md bg-yellow-100 text-yellow-800">
                                                Not Returned
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('services.editStatus', ['service_reservation' => $reservation->id]) }}" 
                                               class="px-3 py-1 text-white bg-pr-400 hover:bg-pr-500 font-medium rounded-md text-center transition duration-150">
                                                Edit Status
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-3 text-center text-gray-500">
                                        No reservations found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Services Table -->
                <div class="mt-12">
                    <div class="flex items-center justify-center mb-6">
                        <hr class="flex-1 h-0.5 bg-pr-400">
                        <h3 class="px-4 font-car font-bold text-gray-600 text-xl">SERVICES</h3>
                        <hr class="flex-1 h-0.5 bg-pr-400">
                    </div>

                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">Client</th>
                                        <th class="px-4 py-3">Service</th>
                                        <th class="px-4 py-3">Scheduled Date</th>
                                        <th class="px-4 py-3">Remaining Days</th>
                                        <th class="px-4 py-3">Price</th>
                                        <th class="px-4 py-3">Payment Status</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @forelse($serviceReservations as $service)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full" 
                                                         src="{{ $service->user->avatar ?? '/images/user.png' }}" 
                                                         alt="" loading="lazy">
                                                </div>
                                                <div>
                                                    @if($service->user)
                                                        <p class="font-semibold">{{ $service->user->name }}</p>
                                                        <p class="text-xs text-gray-600">{{ $service->user->email }}</p>
                                                    @else
                                                        <p class="font-semibold text-red-500">[User Deleted]</p>
                                                        <p class="text-xs text-gray-600">-</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($service->service)
                                                {{ $service->service->servicename }}
                                            @else
                                                <span class="text-red-500">[Service Deleted]</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ Carbon\Carbon::parse($service->scheduled_date)->format('y-m-d') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ $service->remaining_days }} days
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($service->service)
                                                ₱{{ $service->service->price }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 font-semibold leading-tight rounded-md
                                                {{ $service->payment_status == 'unpaid' ? 'bg-yellow-300 text-white' : 'bg-green-500 text-white px-5' }}">
                                                {{ ucfirst($service->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 font-semibold leading-tight rounded-md
                                                {{ $service->status == 'pending' ? 'bg-yellow-300 text-white' : 
                                                   ($service->status == 'rejected' ? 'bg-red-500 text-white' : 
                                                   ($service->status == 'completed' ? 'bg-black text-white' : 
                                                   'bg-green-500 text-white px-4')) }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('services.editStatus', ['service_reservation' => $service->id]) }}" 
                                                   class="px-3 py-1 text-white bg-pr-400 hover:bg-pr-500 font-medium rounded-md text-center transition duration-150">
                                                    Edit Status
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-3 text-center text-gray-500">
                                            No service reservations found
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
