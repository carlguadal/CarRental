@extends('layouts.myapp')

@section('content')
<div class="bg-sec-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Available Cars</h1>
            <p class="mt-4 text-xl text-gray-600">Find your perfect rental car from our premium selection</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form action="{{ route('cars.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                    <input type="text" name="brand" id="brand" value="{{ request('brand') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                           placeholder="e.g. Toyota, Honda">
                </div>
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" id="model" value="{{ request('model') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-200"
                           placeholder="e.g. Camry, Civic">
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
                <div class="md:col-span-4">
                    <button type="submit" class="w-full bg-pr-400 hover:bg-pr-500 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                        Search Cars
                    </button>
                </div>
            </form>
        </div>

        <!-- Cars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($cars as $car)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ $car->image }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $car->brand }} {{ $car->model }}</h3>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $car->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                        <div>
                            <span class="text-gray-600">Year:</span>
                            <span class="font-medium">{{ $car->year }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $car->type }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Seats:</span>
                            <span class="font-medium">{{ $car->seats }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Transmission:</span>
                            <span class="font-medium">{{ $car->transmission }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-600">Daily Rate</span>
                            <div class="text-2xl font-bold text-gray-900">${{ number_format($car->price, 2) }}</div>
                        </div>
                        @if($car->discount > 0)
                            <div class="text-sm font-semibold text-green-600">{{ $car->discount }}% OFF</div>
                        @endif
                    </div>

                    <a href="{{ route('cars.show', $car) }}" 
                       class="block w-full bg-pr-400 hover:bg-pr-500 text-white text-center font-bold py-2 px-4 rounded-md transition duration-150">
                        View Details
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <h3 class="text-xl text-gray-600">No cars available at the moment.</h3>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection 