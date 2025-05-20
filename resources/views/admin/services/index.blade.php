@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Services Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-cogs text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Services</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ App\Models\Service::count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Services Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Services</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ App\Models\Service::where('status', 'available')->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Categories Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-tags text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Service Categories</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $services->unique('category')->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <hr class="w-32 border-t-2 border-orange-500">
                    <h2 class="text-xl font-bold text-gray-700">SERVICES</h2>
                    <hr class="w-32 border-t-2 border-orange-500">
                </div>
                <a href="{{ route('services.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">Add New Service</a>
        </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                    <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($services as $service)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $service->image }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                        </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 max-w-xs truncate">{{ $service->description }}</div>
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($service->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('services.edit', $service->id) }}" class="text-orange-500 hover:text-orange-600">Edit</a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
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
                {{ $services->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
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