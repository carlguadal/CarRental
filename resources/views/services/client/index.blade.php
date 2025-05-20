@extends('layouts.myapp')

@section('content')
<div class="bg-sec-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Our Services</h1>
            <p class="mt-4 text-xl text-gray-600">Choose from our wide range of automotive services</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form action="{{ route('client.services.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Services</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                           placeholder="Search by name or description">
                </div>
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                           placeholder="Minimum price">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                           placeholder="Maximum price">
                </div>
                <div class="md:col-span-3">
                    <button type="submit" class="w-full bg-pr-400 hover:bg-pr-500 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                        Search Services
                    </button>
                </div>
            </form>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ $service->image }}" alt="{{ $service->servicename }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $service->servicename }}</h3>
                        <div class="flex items-center">
                            @for($i = 0; $i < $service->stars; $i++)
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-600">Service Fee</span>
                            <div class="text-2xl font-bold text-gray-900">₱{{ number_format($service->price, 2) }}</div>
                        </div>
                        @if($service->reduce > 0)
                            <div class="text-sm font-semibold text-green-600">{{ $service->reduce }}% OFF</div>
                        @endif
                    </div>

                    <a href="{{ route('client.services.show', $service) }}" 
                       class="block w-full bg-pr-400 hover:bg-pr-500 text-white text-center font-bold py-2 px-4 rounded-md transition duration-150">
                        Book Service
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <h3 class="text-xl text-gray-600">No services available at the moment.</h3>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection 