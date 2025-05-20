<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RealRentCar') }} - Admin</title>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('flatpickr::components.style')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <nav class="bg-white">
        <div class="max-w-full px-8 mx-auto">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="/images/logos/logo.png" class="h-16" alt="B&P Car Rentals">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center justify-center flex-1 space-x-12">
                    <a href="{{ route('adminDashboard') }}" 
                       class="text-gray-900 hover:text-gray-500 px-3 py-2 text-base font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('cars.index') }}"
                       class="text-gray-900 hover:text-gray-500 px-3 py-2 text-base font-medium">
                        Cars
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="text-gray-900 hover:text-gray-500 px-3 py-2 text-base font-medium">
                        Users
                    </a>
                    <a href="{{ route('services.index') }}"
                       class="text-gray-900 hover:text-gray-500 px-3 py-2 text-base font-medium">
                        Services
                    </a>
                    <a href="{{ route('admin.archive') }}"
                       class="text-gray-900 hover:text-gray-500 px-3 py-2 text-base font-medium">
                        Archive
                    </a>
                </div>

                <!-- Admin Dropdown -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-pr-400 transition-colors duration-200">
                            <img loading="lazy" src="/images/user.png" width="24" alt="user icon" class="mr-3">
                            <span>Logout ( {{ Auth::user()->name }} )</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-6">
        @yield('content')
    </main>
    @stack('scripts')
</body>

</html> 