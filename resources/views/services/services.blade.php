@extends('layouts.myapp')
@section('content')
    <div class="bg-gray-200 mx-auto max-w-screen-xl mt-10 p-3 rounded-md shadow-xl">
        <form action="{{ route('client.services.index') }}">
            <div class="flex justify-center md:flex-row flex-col md:gap-28 gap-4">
                <div class="flex justify-evenly md:flex-row flex-col md:gap-16 gap-2">
                    <input type="text" placeholder="Service Name" name="servicename"
                        class="block rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                    <input type="number" placeholder="₱ Minimum Price" name="min_price"
                        class="block rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                    <input type="number" placeholder="₱ Maximum Price" name="max_price"
                        class="block rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                </div>
                <button class="bg-pr-400 rounded-md text-white p-2 w-20 font-medium hover:bg-pr-500" type="submit">Search</button>
            </div>
        </form>
    </div>
    <div class="mt-6 mb-2 grid md:grid-cols-3 justify-center items-center mx-auto max-w-screen-xl">
        @foreach ($services as $service)
            <div class="relative md:m-10 m-4 flex w-full max-w-xs flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl">
                    <img loading="lazy" class="object-cover w-full h-full" src="{{ $service->image ?? '/images/default-service.jpg' }}" alt="Service Image" />
                    <span class="absolute top-0 left-0 m-2 rounded-full bg-pr-400 px-2 text-center text-sm font-medium text-white">10 % OFF</span>
                </div>
                <div class="mt-4 px-5 pb-5">
                    <div>
                        <h5 class="font-bold text-xl tracking-tight text-slate-900">{{ $service->servicename }}</h5>
                    </div>
                    <div class="mt-2 mb-5">
                        <p class="text-gray-600">{{ $service->description }}</p>
                    </div>
                    <div class="mt-2 mb-5 flex items-center justify-between">
                        <p class="text-lg font-bold text-slate-900">Service Fee</p>
                        <p class="text-3xl font-bold text-slate-900">₱{{ number_format($service->price, 2) }}</p>
                    </div>
                    <div class="mt-2 mb-5 flex items-center justify-between">
                        <p>
                            <span class="text-3xl font-bold text-slate-900">₱{{ $service->price }}</span>
                            <span class="text-sm text-slate-900 line-through">₱{{ number_format($service->price * 1.1, 2) }}</span>
                        </p>
                        <div class="flex items-center">
                            @for ($i = 0; $i < 5; $i++)
                                <svg aria-hidden="true" class="h-5 w-5 text-pr-300" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                            <span class="mr-2 ml-3 rounded bg-pr-300 px-2.5 py-0.5 text-xs font-semibold">5.0</span>
                        </div>
                    </div>
                    <a href="{{ route('service.details', ['service' => $service->id]) }}"
                        class="flex items-center justify-center rounded-md bg-slate-900 hover:bg-pr-400 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Reserve Service
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mb-12 w-full">
        {{ $services->links('pagination::tailwind') }}
    </div>
@endsection