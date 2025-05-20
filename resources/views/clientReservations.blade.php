@extends('layouts.myapp')
@section('content')
    {{-- Success Message Toast --}}
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}"
            });
        </script>
    @endif

    <div class="mx-auto max-w-screen-xl">
        <div class="">
            <div class="my-6 py-6 px-4 bg-white rounded-md flex justify-start items-center flex-wrap md:flex-nowrap gap-y-4 md:gap-y-0">
                <div class="flex justify-center w-1/2 md:w-1/4">
                    <img loading="lazy" class="w-44 h-44 rounded-full border-2 border-pr-400 shadow-lg shadow-pr-400/50"
                        src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="w-1/2 md:w-1/4">
                    <h2 class="font-medium text-slate-600 text-5xl">{{ Auth::user()->name }}</h2>
                    <h2 class="text-lg font-medium text-gray-900">{{ Auth::user()->email }}</h2>
                </div>
                <div class="w-full grid grid-cols-2 gap-4 md:w-1/2">
                    <div
                        class="bg-white-300 p-4 rounded-md border-2 border-blue-700 flex flex-col justify-center items-center">
                        <p class="text-lg font-car font-normal text-gray-500">Total Reservations </p>
                        <h2 class="font-medium text-blue-600 text-3xl">{{ Auth::user()->reservations->count() }}</h2>
                    </div>

                    <div
                        class="bg-white-300 p-4 rounded-md border-2 border-green-700 flex flex-col justify-center items-center">
                        <p class="text-lg font-car font-normal text-gray-500">Active Reservations </p>
                        <h2 class="font-medium text-green-600 text-3xl">
                            {{ Auth::user()->reservations->where('status', 'Active')->count() }}</h2>
                    </div>

                    <div
                        class="bg-white-300 p-4 rounded-md border-2 border-yellow-700 flex flex-col justify-center items-center">
                        <p class="text-lg font-car font-normal text-gray-500">Pending Reservations </p>
                        <h2 class="font-medium text-yellow-600 text-3xl">
                            {{ Auth::user()->reservations->where('status', 'Pending')->count() }}</h2>
                    </div>

                    <div
                        class="bg-white-300 p-4 rounded-md border-2 border-red-700 flex flex-col justify-center items-center">
                        <p class="text-lg font-car font-normal text-gray-500">Canceled Reservations </p>
                        <h2 class="font-medium text-red-600 text-3xl">
                            {{ Auth::user()->reservations->where('status', 'Canceled')->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-md my-12">
                <h2 class="text-3xl font-car font-medium text-gray-500 text-center mb-4">Reservations</h2>
                @forelse ($reservations as $reservation)
                    <div class="flex justify-center w-full mb-4 rounded-lg bg-gray-200">
                        <div class="md:w-1/3 w-full h-[250px]  overflow-hidden p-1 hidden md:block  m-3 rounded-md">
                            <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                src="{{ $reservation->car->image }}" alt="">
                        </div>
                        <div class="m-3 p-1 md:w-2/3 w-full">
                            <h2 class="mt-2 font-car text-gray-800 text-2xl font-medium">{{ $reservation->car->brand }}
                                {{ $reservation->car->model }} {{ $reservation->car->engine }}</h2>
                            <div class="mt-4 flex md:flex-row flex-col justify-start md:gap-10 gap-5">
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">From: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->start_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">To: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Price: </p>
                                    <p class="text-pr-600 font-semibold text-lg">{{ $reservation->total_price }} <span
                                            class="text-black">₱</span> </p>
                                </div>



                            </div>
                            <div class="mt-8 flex justify-start md:gap-16 gap-6">

                                <div class="flex md:gap-2 items-center">
                                    <p class="text-lg font-medium">Payment: </p>
                                    <div class="px-4 py-3 text-sm ">
                                        @if ($reservation->payment_status == 'Pending')
                                            <span
                                                class="p-2 text-white rounded-md bg-yellow-300 ">{{ $reservation->payment_status }}</span>
                                        @elseif ($reservation->payment_status == 'Canceled')
                                            <span
                                                class="p-2 text-white rounded-md bg-red-500 ">{{ $reservation->payment_status }}</span>
                                        @elseif ($reservation->payment_status == 'Paid')
                                            <span
                                                class="p-2 text-white rounded-md bg-green-500 px-5">{{ $reservation->payment_status }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Reservation: </p>
                                    <div class="px-4 py-3 text-sm ">
                                        @if ($reservation->status == 'Pending')
                                            <span
                                                class="p-2 text-white rounded-md bg-yellow-300 ">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Ended')
                                            <span
                                                class="p-2 text-white rounded-md bg-black ">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Active')
                                            <span
                                                class="p-2 text-white rounded-md bg-green-500 px-4">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Canceled')
                                            <span
                                                class="p-2 text-white rounded-md bg-red-500 ">{{ $reservation->status }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="w-[350px] h-[250px]  overflow-hidden p-1  md:hidden  mx-auto mt-3 rounded-md">
                                <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                    src="{{ $reservation->car->image }}" alt="">
                            </div>

                            <div class="mt-8 text-center w-full px-2">
                                <a href="{{ route('invoice', ['reservation' => $reservation->id]) }}" target="_blank">
                                    <button class="bg-pr-400 p-3 text-white font-bold hover:bg-black w-full rounded-md ">
                                        Get Reservation Invoice</button>
                                </a>
                                @if($reservation->down_payment_status === 'unpaid')
                                    <a href="{{ route('payment.down.form', $reservation) }}">
                                        <button class="bg-green-500 p-3 text-white font-bold hover:bg-green-700 w-full rounded-md mt-2">
                                            Pay Down Payment
                                        </button>
                                    </a>
                                @elseif($reservation->down_payment_status === 'paid')
                                    <div class="mt-2 text-green-700 font-bold">Down Payment Paid</div>
                                    @if($reservation->final_payment_status === 'unpaid')
                                        <a href="{{ route('payment.final.form', $reservation) }}">
                                            <button class="bg-blue-500 p-3 text-white font-bold hover:bg-blue-700 w-full rounded-md mt-2">
                                                Pay Final Payment
                                            </button>
                                        </a>
                                    @elseif($reservation->final_payment_status === 'paid')
                                        <div class="mt-2 text-blue-700 font-bold">Final Payment Paid</div>
                                        @if($reservation->status !== 'Ended')
                                            <form action="{{ route('reservation.return', $reservation) }}" method="POST" class="mt-2">
                                                @csrf
                                                <button type="submit" class="bg-purple-500 p-3 text-white font-bold hover:bg-purple-700 w-full rounded-md">
                                                    Return Car
                                                </button>
                                            </form>
                                        @else
                                            <div class="mt-2 text-purple-700 font-bold">Car Returned</div>
                                        @endif
                                    @endif
                                @endif
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="h-full w-full flex justify-center items-center">
                        <h2 class="font-medium text-2xl ">There no reservations yet</h2>
                    </div>
                @endforelse

            </div>

            <div class="bg-white p-4 rounded-md my-12">
                <h2 class="text-3xl font-car font-medium text-gray-500 text-center mb-4">Active Reservations</h2>
                @forelse ($reservations as $reservation)
                    <div class="flex justify-center w-full mb-4 rounded-lg bg-gray-200">
                        <div class="md:w-1/3 w-full h-[250px] overflow-hidden p-1 hidden md:block m-3 rounded-md">
                            <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                src="{{ $reservation->car->image }}" alt="">
                        </div>
                        <div class="m-3 p-1 md:w-2/3 w-full">
                            <h2 class="mt-2 font-car text-gray-800 text-2xl font-medium">{{ $reservation->car->brand }}
                                {{ $reservation->car->model }} {{ $reservation->car->engine }}</h2>
                            <div class="mt-4 flex md:flex-row flex-col justify-start md:gap-10 gap-5">
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">From: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->start_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">To: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Price: </p>
                                    <p class="text-pr-600 font-semibold text-lg">{{ $reservation->total_price }} <span
                                            class="text-black">₱</span> </p>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-start md:gap-16 gap-6">
                                <div class="flex md:gap-2 items-center">
                                    <p class="text-lg font-medium">Payment: </p>
                                    <div class="px-4 py-3 text-sm">
                                        @if ($reservation->payment_status == 'Pending')
                                            <span class="p-2 text-white rounded-md bg-yellow-300">{{ $reservation->payment_status }}</span>
                                        @elseif ($reservation->payment_status == 'Canceled')
                                            <span class="p-2 text-white rounded-md bg-red-500">{{ $reservation->payment_status }}</span>
                                        @elseif ($reservation->payment_status == 'Paid')
                                            <span class="p-2 text-white rounded-md bg-green-500 px-5">{{ $reservation->payment_status }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Status: </p>
                                    <div class="px-4 py-3 text-sm">
                                        @if ($reservation->status == 'Pending')
                                            <span class="p-2 text-white rounded-md bg-yellow-300">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Ended')
                                            <span class="p-2 text-white rounded-md bg-black">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Active')
                                            <span class="p-2 text-white rounded-md bg-green-500 px-4">{{ $reservation->status }}</span>
                                        @elseif ($reservation->status == 'Canceled')
                                            <span class="p-2 text-white rounded-md bg-red-500">{{ $reservation->status }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="w-[350px] h-[250px] overflow-hidden p-1 md:hidden mx-auto mt-3 rounded-md">
                                <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                    src="{{ $reservation->car->image }}" alt="">
                            </div>
                            <div class="mt-8 text-center w-full px-2">
                                <a href="{{ route('invoice', ['reservation' => $reservation->id]) }}" target="_blank">
                                    <button class="bg-pr-400 p-3 text-white font-bold hover:bg-black w-full rounded-md">
                                        Get Reservation Invoice</button>
                                </a>
                                @if($reservation->down_payment_status === 'unpaid')
                                    <a href="{{ route('payment.down.form', $reservation) }}">
                                        <button class="bg-green-500 p-3 text-white font-bold hover:bg-green-700 w-full rounded-md mt-2">
                                            Pay Down Payment
                                        </button>
                                    </a>
                                @elseif($reservation->down_payment_status === 'paid')
                                    <div class="mt-2 text-green-700 font-bold">Down Payment Paid</div>
                                    @if($reservation->final_payment_status === 'unpaid')
                                        <a href="{{ route('payment.final.form', $reservation) }}">
                                            <button class="bg-blue-500 p-3 text-white font-bold hover:bg-blue-700 w-full rounded-md mt-2">
                                                Pay Final Payment
                                            </button>
                                        </a>
                                    @elseif($reservation->final_payment_status === 'paid')
                                        <div class="mt-2 text-blue-700 font-bold">Final Payment Paid</div>
                                        @if($reservation->status !== 'Ended')
                                            <form action="{{ route('reservation.return', $reservation) }}" method="POST" class="mt-2">
                                                @csrf
                                                <button type="submit" class="bg-purple-500 p-3 text-white font-bold hover:bg-purple-700 w-full rounded-md">
                                                    Return Car
                                                </button>
                                            </form>
                                        @else
                                            <div class="mt-2 text-purple-700 font-bold">Car Returned</div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full w-full flex justify-center items-center">
                        <h2 class="font-medium text-2xl">No active reservations</h2>
                    </div>
                @endforelse
            </div>

            {{-- Past Reservations Section --}}
            <div class="bg-white p-4 rounded-md my-12">
                <h2 class="text-3xl font-car font-medium text-gray-500 text-center mb-4">Past Reservations</h2>
                @php
                    $pastReservations = \App\Models\Reservation::where('user_id', Auth::user()->id)
                        ->where('status', 'Ended')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp
                @forelse ($pastReservations as $reservation)
                    <div class="flex justify-center w-full mb-4 rounded-lg bg-gray-200">
                        <div class="md:w-1/3 w-full h-[250px] overflow-hidden p-1 hidden md:block m-3 rounded-md">
                            <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                src="{{ $reservation->car->image }}" alt="">
                        </div>
                        <div class="m-3 p-1 md:w-2/3 w-full">
                            <h2 class="mt-2 font-car text-gray-800 text-2xl font-medium">{{ $reservation->car->brand }}
                                {{ $reservation->car->model }} {{ $reservation->car->engine }}</h2>
                            <div class="mt-4 flex md:flex-row flex-col justify-start md:gap-10 gap-5">
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">From: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->start_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">To: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->format('y-m-d') }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Returned: </p>
                                    <p class="text-pr-600 font-semibold text-lg">
                                        {{ Carbon\Carbon::parse($reservation->returned_at)->format('y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-start md:gap-16 gap-6">
                                <div class="flex md:gap-2 items-center">
                                    <p class="text-lg font-medium">Payment: </p>
                                    <div class="px-4 py-3 text-sm">
                                        <span class="p-2 text-white rounded-md bg-green-500 px-5">Completed</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <p class="text-lg font-medium">Status: </p>
                                    <div class="px-4 py-3 text-sm">
                                        <span class="p-2 text-white rounded-md bg-black">Ended</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-[350px] h-[250px] overflow-hidden p-1 md:hidden mx-auto mt-3 rounded-md">
                                <img loading="lazy" class="w-full h-full object-cover overflow-hidden rounded-md"
                                    src="{{ $reservation->car->image }}" alt="">
                            </div>
                            <div class="mt-8 text-center w-full px-2">
                                <a href="{{ route('invoice', ['reservation' => $reservation->id]) }}" target="_blank">
                                    <button class="bg-pr-400 p-3 text-white font-bold hover:bg-black w-full rounded-md">
                                        View Past Invoice</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full w-full flex justify-center items-center">
                        <h2 class="font-medium text-2xl">No past reservations</h2>
                    </div>
                @endforelse
            </div>

            {{-- Service Reservations Section --}}
            <div class="bg-white p-4 rounded-md my-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">My Service Reservations</h2>
                <p class="mt-2 text-gray-600 mb-4">View and manage your service appointments</p>
                @if(session('service_success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('service_success') }}
                    </div>
                @endif
                @if($serviceReservations->isEmpty())
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
                                @foreach($serviceReservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->service->servicename ?? $reservation->service->name ?? 'Service' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ number_format($reservation->service->price ?? 0, 2) }} ₱
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
        </div>
    </div>
@endsection
