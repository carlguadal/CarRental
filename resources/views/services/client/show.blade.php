@extends('layouts.myapp')

@section('content')
<div class="bg-sec-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Service Image -->
                <div class="md:w-1/2">
                    <img src="{{ $service->image }}" alt="{{ $service->servicename }}" class="w-full h-96 object-cover">
                </div>

                <!-- Service Details -->
                <div class="md:w-1/2 p-8">
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $service->servicename }}</h1>
                        <div class="flex items-center">
                            @for($i = 0; $i < $service->stars; $i++)
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <p class="text-gray-600 mb-6">{{ $service->description }}</p>

                    <div class="mb-6">
                        <div class="flex items-baseline mb-2">
                            <span class="text-2xl font-bold text-gray-900">₱{{ number_format($service->price, 2) }}</span>
                            @if($service->reduce > 0)
                                <span class="ml-2 text-sm font-semibold text-green-600">{{ $service->reduce }}% OFF</span>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(!auth()->user()->is_admin)
                            <form action="{{ route('client.services.reserve', $service) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700">Preferred Date</label>
                                    <input type="date" name="scheduled_date" id="scheduled_date" required
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200">
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                    <textarea name="notes" id="notes" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                                              placeholder="Any special requirements or notes for this service?"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-pr-400 hover:bg-pr-500 text-white font-bold py-3 px-4 rounded-md transition duration-150">
                                    Book Service
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4 px-6 bg-gray-100 rounded-lg">
                                <p class="text-gray-600">Admin accounts cannot make service reservations.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4 px-6 bg-gray-100 rounded-lg">
                            <p class="text-gray-600">Please <a href="{{ route('login') }}" class="text-pr-400 hover:text-pr-500 font-medium">login</a> to book this service.</p>
                        </div>
                    @endauth

                    <div class="mt-8">
                        <a href="{{ route('client.services.index') }}" class="text-pr-400 hover:text-pr-500 font-medium">
                            &larr; Back to Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 