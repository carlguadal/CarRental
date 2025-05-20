@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Cars Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-car text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Cars</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $cars->total() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Cars Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Available Cars</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $cars->where('status', 'available')->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reserved Cars Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Reserved Cars</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $cars->where('status', 'reserved')->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Table -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <hr class="w-32 border-t-2 border-orange-500">
                    <h2 class="text-xl font-bold text-gray-700">CARS</h2>
                    <hr class="w-32 border-t-2 border-orange-500">
                </div>
                <a href="{{ route('cars.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">Add New Car</a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                    <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price/Day</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cars as $car)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-20 h-20 rounded-md border-2 border-orange-500 overflow-hidden">
                                        <img src="{{ $car->image }}" alt="car image" class="w-full h-full object-cover">
                                </div>
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $car->brand }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $car->model }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $car->engine }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($car->price_per_day, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $car->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $car->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($car->status) }}
                                    </span>
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('cars.edit', $car->id) }}" class="text-orange-500 hover:text-orange-600">Edit</a>
                                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 px-3 py-1 rounded-md">Archive</button>
                                </form>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $cars->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Car deleted successfully.',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3500
                });
            </script>
        @endif
@endsection
