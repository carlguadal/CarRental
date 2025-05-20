@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Admins Section -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Admins</h2>
            <a href="{{ route('users.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">add new admin</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users->where('role', 'admin') as $admin)
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full" src="{{ $admin->avatar ?? '/images/user.png' }}" alt="{{ $admin->name }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-medium text-gray-900 truncate">{{ $admin->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $admin->email }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Clients Section -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Clients</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined At</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservations</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users->where('role', 'client') as $client)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $client->avatar ?? '/images/user.png' }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $client->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $client->reservations_count ?? 0 }} active reservation(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('users.destroy', $client->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 px-3 py-1 rounded-md">Archive</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif
@endsection 