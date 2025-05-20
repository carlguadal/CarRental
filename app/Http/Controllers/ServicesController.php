<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Service::query();

        if (request('servicename')) {
            $query->where('servicename', 'like', '%' . request('servicename') . '%');
        }

        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $services = $query->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'servicename' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'reduce' => 'required|numeric|min:0|max:100',
            'stars' => 'required|integer|min:1|max:5',
            'status' => 'required|in:available,unavailable',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $service = new Service();
        $service->servicename = $request->servicename;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->reduce = $request->reduce;
        $service->stars = $request->stars;
        $service->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/services', $filename);
            $service->image = Storage::url($path);
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'servicename' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'reduce' => 'required|numeric|min:0|max:100',
            'stars' => 'required|integer|min:1|max:5',
            'status' => 'required|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $service->servicename = $request->servicename;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->reduce = $request->reduce;
        $service->stars = $request->stars;
        $service->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                $oldPath = str_replace('/storage/', '/public/', $service->image);
                Storage::delete($oldPath);
            }

            // Store new image
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/services', $filename);
            $service->image = Storage::url($path);
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            $path = str_replace('/storage/', '/public/', $service->image);
            Storage::delete($path);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }

    public function search(Request $request)
    {
        $query = Service::query();

        if ($request->servicename) {
            $query->where('servicename', 'like', '%' . $request->servicename . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $services = $query->where('status', 'available')->paginate(9);
        return view('services.services', compact('services'));
    }

    /**
     * Display a listing of archived services.
     */
    public function archive()
    {
        $cars = \App\Models\Car::onlyTrashed()->latest()->paginate(8);
        $services = \App\Models\Service::onlyTrashed()->latest()->paginate(8);
        $users = \App\Models\User::onlyTrashed()->latest()->paginate(8);
        return view('admin.archiveAll', compact('cars', 'services', 'users'));
    }

    /**
     * Restore an archived service.
     */
    public function restore(Service $service)
    {
        $service->restore();
        return redirect()->route('services.archive')->with('success', 'Service restored successfully.');
    }

    public function forceDelete($service)
    {
        $service = \App\Models\Service::withTrashed()->findOrFail($service);
        $service->forceDelete();
        return redirect()->route('admin.archive')->with('success', 'Service permanently deleted.');
    }
}