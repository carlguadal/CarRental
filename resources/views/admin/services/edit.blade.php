@extends('layouts.myapp')
@section('content')
    <div class="mx-auto max-w-screen-xl p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-6">Edit service details</h2>
            
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="servicename" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input type="text" name="servicename" id="servicename" required value="{{ $service->servicename }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price per day</label>
                        <input type="number" name="price" id="price" required step="0.01" value="{{ $service->price }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="reduce" class="block text-sm font-medium text-gray-700">Reduce %</label>
                        <input type="number" name="reduce" id="reduce" required value="{{ $service->reduce }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="stars" class="block text-sm font-medium text-gray-700">Service stars</label>
                        <select name="stars" id="stars" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $service->stars == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">{{ $service->description }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Cover photo</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-pr-400 hover:text-pr-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-pr-400">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="image" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                        @if($service->image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Current image:</p>
                                <img src="{{ $service->image }}" alt="Current service image" class="mt-2 h-32 w-auto">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pr-400 focus:ring focus:ring-pr-400 focus:ring-opacity-50">
                            <option value="available" {{ $service->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ $service->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('services.index') }}" class="bg-gray-200 py-2 px-4 rounded-md hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="bg-pr-400 text-white py-2 px-4 rounded-md hover:bg-pr-500">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection 