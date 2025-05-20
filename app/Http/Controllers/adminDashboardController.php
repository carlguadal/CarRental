<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\ServiceReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        try {
            // Get counts for dashboard statistics
            $totalCars = Car::count();
            $availableCars = Car::where('status', 'available')->count();
            $totalUsers = User::where('role', 'client')->count();
            $adminCount = User::where('role', 'admin')->count();
            
            // Get available services count
            $availableServices = Service::where('status', 'available')->count();
            
            // Get active reservations (not completed or cancelled)
            $activeReservations = Reservation::whereIn('status', ['active', 'pending'])
                ->count();

            // Get recent reservations with additional data
            $recentReservations = Reservation::with(['user', 'car'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($reservation) {
                    // Calculate duration and remaining days
                    $startDate = Carbon::parse($reservation->start_date);
                    $endDate = Carbon::parse($reservation->end_date);
                    $now = Carbon::now();
                    
                    $reservation->duration = $startDate->diffInDays($endDate);
                    $reservation->remaining_days = $now->gt($endDate) ? 0 : $now->diffInDays($endDate);
                    
                    return $reservation;
                });

            // Get recent service reservations
            $serviceReservations = ServiceReservation::with(['user', 'service'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($reservation) {
                    $scheduledDate = Carbon::parse($reservation->scheduled_date);
                    $now = Carbon::now();
                    
                    // Add remaining days until scheduled date
                    $reservation->remaining_days = $now->gt($scheduledDate) ? 0 : $now->diffInDays($scheduledDate);
                    
                    return $reservation;
                });

            return view('admin.adminDashboard', compact(
                'totalCars',
                'availableCars',
                'totalUsers',
                'adminCount',
                'activeReservations',
                'availableServices',
                'recentReservations',
                'serviceReservations'
            ));
        } catch (\Exception $e) {
            // Log the error and return with default values
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return view('admin.dashboard', [
                'totalCars' => 0,
                'availableCars' => 0,
                'totalUsers' => 0,
                'adminCount' => 0,
                'activeReservations' => 0,
                'activeInsurances' => 0,
                'recentReservations' => collect([])
            ]);
        }
    }

    public function archiveAll(Request $request)
    {
        $cars = \App\Models\Car::onlyTrashed()->latest()->paginate(5, ['*'], 'cars_page');
        $services = \App\Models\Service::onlyTrashed()->latest()->paginate(5, ['*'], 'services_page');
        $users = \App\Models\User::onlyTrashed()->latest()->paginate(5, ['*'], 'users_page');
        return view('admin.archiveAll', compact('cars', 'services', 'users'));
    }
}
