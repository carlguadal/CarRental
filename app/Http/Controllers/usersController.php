<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::withCount(['reservations' => function($query) {
            $query->where('status', 'active');
        }])->get();
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'client',
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of archived users.
     */
    public function archive()
    {
        $cars = \App\Models\Car::onlyTrashed()->latest()->paginate(8);
        $services = \App\Models\Service::onlyTrashed()->latest()->paginate(8);
        $users = \App\Models\User::onlyTrashed()->latest()->paginate(8);
        return view('admin.archiveAll', compact('cars', 'services', 'users'));
    }

    /**
     * Restore an archived user.
     */
    public function restore(User $user)
    {
        $user->restore();
        return redirect()->route('users.archive')->with('success', 'User restored successfully.');
    }

    public function forceDelete($user)
    {
        $user = \App\Models\User::withTrashed()->findOrFail($user);
        $user->forceDelete();
        return redirect()->route('admin.archive')->with('success', 'User permanently deleted.');
    }
}
