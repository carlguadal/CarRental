@extends('layouts.admin')

@section('content')
<div class="flex justify-center min-h-screen bg-sec-400">
    <div class="w-10/12 py-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Archive</h2>

            <!-- Archived Cars Table -->
            <div class="mt-12">
                <div class="flex items-center justify-center mb-6">
                    <hr class="flex-1 h-0.5 bg-pr-400">
                    <h3 class="px-4 font-car font-bold text-gray-600 text-xl">ARCHIVED CARS</h3>
                    <hr class="flex-1 h-0.5 bg-pr-400">
                </div>
                <div class="w-full overflow-hidden rounded-lg shadow-xs border border-gray-200">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">Image</th>
                                    <th class="px-4 py-3">Brand</th>
                                    <th class="px-4 py-3">Model</th>
                                    <th class="px-4 py-3">Engine</th>
                                    <th class="px-4 py-3">Price/Day</th>
                                    <th class="px-4 py-3">Archived At</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse ($cars as $car)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm">
                                        <img src="{{ $car->image }}" alt="{{ $car->brand }} {{ $car->model }}" class="h-12 w-20 object-cover rounded">
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $car->brand }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $car->model }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $car->engine }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">₱{{ number_format($car->price ?? $car->price_per_day, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $car->deleted_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <form action="{{ url('admin/cars/' . $car->id . '/restore') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-md">
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ url('admin/cars/' . $car->id . '/force-delete') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="permanent-delete-btn text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md ml-2">
                                                Permanent Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                        No archived cars found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $cars->appends(['services_page' => request('services_page'), 'users_page' => request('users_page')])->links('pagination::tailwind', ['paginator' => $cars, 'pageName' => 'cars_page']) }}
                    </div>
                </div>
            </div>

            <!-- Archived Services Table -->
            <div class="mt-12">
                <div class="flex items-center justify-center mb-6">
                    <hr class="flex-1 h-0.5 bg-pr-400">
                    <h3 class="px-4 font-car font-bold text-gray-600 text-xl">ARCHIVED SERVICES</h3>
                    <hr class="flex-1 h-0.5 bg-pr-400">
                </div>
                <div class="w-full overflow-hidden rounded-lg shadow-xs border border-gray-200">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">Service Name</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Reduce %</th>
                                    <th class="px-4 py-3">Stars</th>
                                    <th class="px-4 py-3">Archived At</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse ($services as $service)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $service->servicename }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">₱{{ number_format($service->price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $service->reduce }}%</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        @for ($i = 0; $i < $service->stars; $i++)
                                            ⭐
                                        @endfor
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $service->deleted_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <form action="{{ url('admin/services/' . $service->id . '/restore') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-md">
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ url('admin/services/' . $service->id . '/force-delete') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="permanent-delete-btn text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md ml-2">
                                                Permanent Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                        No archived services found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $services->appends(['users_page' => request('users_page')])->links('pagination::tailwind', ['paginator' => $services, 'pageName' => 'services_page']) }}
                    </div>
                </div>
            </div>

            <!-- Archived Users Table -->
            <div class="mt-12">
                <div class="flex items-center justify-center mb-6">
                    <hr class="flex-1 h-0.5 bg-pr-400">
                    <h3 class="px-4 font-car font-bold text-gray-600 text-xl">ARCHIVED USERS</h3>
                    <hr class="flex-1 h-0.5 bg-pr-400">
                </div>
                <div class="w-full overflow-hidden rounded-lg shadow-xs border border-gray-200">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Phone</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Archived At</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse ($users as $user)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->phone }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->deleted_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <form action="{{ url('admin/users/' . $user->id . '/restore') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-md">
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ url('admin/users/' . $user->id . '/force-delete') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="permanent-delete-btn text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-md ml-2">
                                                Permanent Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                        No archived users found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $users->appends(['services_page' => request('services_page')])->links('pagination::tailwind', ['paginator' => $users, 'pageName' => 'users_page']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.permanent-delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = btn.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone. The item will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush 