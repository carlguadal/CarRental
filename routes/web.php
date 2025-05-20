<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\clientCarController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\addNewAdminController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\carSearchController;
use App\Http\Controllers\ClientServicesController;
use App\Models\User;
use App\Models\Car;
use App\Models\Reservation;
use App\Http\Controllers\ServiceReservationsController;
use App\Http\Controllers\PaymentController;


// ------------------- guest routes --------------------------------------- //
Route::get('/', function () {
    $cars = Car::take(6)->where('status', '=', 'available')->get();
    return view('home', compact('cars'));
})->name('home');

Route::get('/cars', [clientCarController::class, 'index'])->name('cars');
Route::get('/cars/search', [carSearchController::class, 'search'])->name('carSearch');
Route::get('/services', [ClientServicesController::class, 'index'])->name('client.services.index');
Route::get('/services/{service}', [ClientServicesController::class, 'show'])->name('client.services.show');
Route::get('/services/search', [ServicesController::class, 'search'])->name('serviceSearch');
Route::get('contact_us', function () {
    return view('contact_us');
})->name('contact_us');

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

Route::redirect('/admin', 'admin/login');

Route::get('/privacy_policy', function () {
    return view('Privacy_Policy');
})->name('privacy_policy');

Route::get('/terms_conditions', function () {
    return view('Terms_Conditions');
})->name('terms_conditions');


// -------------------------------------------------------------------------//




// ------------------- admin routes --------------------------------------- //

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('adminDashboard');

    // Cars
    Route::get('/archive', [AdminDashboardController::class, 'archiveAll'])->name('admin.archive');
    Route::get('/cars/archive', [CarController::class, 'archive'])->name('cars.archive');
    Route::post('/cars/{car}/restore', [CarController::class, 'restore'])->name('cars.restore');
    Route::delete('/cars/{car}/force-delete', [CarController::class, 'forceDelete'])->name('cars.forceDelete');
    Route::resource('cars', CarController::class);
    
    // Users
    Route::get('/users/archive', [UsersController::class, 'archive'])->name('users.archive');
    Route::post('/users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{user}/force-delete', [UsersController::class, 'forceDelete'])->name('users.forceDelete');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/userDetails/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/addAdmin', [UsersController::class, 'create'])->name('users.create');
    Route::post('/addAdmin', [addNewAdminController::class, 'register'])->name('users.store');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Services
    Route::get('services/archive', [ServicesController::class, 'archive'])->name('services.archive');
    Route::post('services/{service}/restore', [ServicesController::class, 'restore'])->name('services.restore');
    Route::delete('services/{service}/force-delete', [ServicesController::class, 'forceDelete'])->name('services.forceDelete');
    Route::resource('services', ServicesController::class);
    Route::get('/service-reservations', [ServicesController::class, 'reservations'])->name('admin.services.reservations');
    Route::put('/service-reservations/{reservation}/status', [ServicesController::class, 'updateReservationStatus'])->name('admin.services.reservations.status');
    Route::put('/service-reservations/{reservation}/payment', [ServicesController::class, 'updatePaymentStatus'])->name('admin.services.reservations.payment');

    // Service Reservations Management
    Route::get('/service-reservations/{service_reservation}/edit-status', [ServiceReservationsController::class, 'editStatus'])->name('services.editStatus');
    Route::put('/service-reservations/{service_reservation}/update-status', [ServiceReservationsController::class, 'updateStatus'])->name('services.updateStatus');
    Route::get('/service-reservations/{service_reservation}/edit-payment', [ServiceReservationsController::class, 'editPayment'])->name('services.editPayment');
    Route::put('/service-reservations/{service_reservation}/update-payment', [ServiceReservationsController::class, 'updatePayment'])->name('services.updatePayment');
});

// --------------------------------------------------------------------------//




// ------------------- client routes --------------------------------------- //

Route::middleware(['auth', 'restrictAdminAccess'])->group(function () {
    Route::get('/reservations/{car}', [ReservationController::class, 'create'])->name('car.reservation');
    Route::post('/reservations/{car}', [ReservationController::class, 'store'])->name('car.reservationStore');
    Route::get('/check-availability/{car}', [ReservationController::class, 'checkAvailability'])->name('car.checkAvailability');
    
    Route::get('/reservations', function () {
        $reservations = Reservation::where('user_id', Auth::user()->id)
            ->where('status', '!=', 'Ended')
            ->orderBy('created_at', 'desc')
            ->get();
        $serviceReservations = \App\Models\ServiceReservation::where('user_id', Auth::user()->id)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('clientReservations', compact('reservations', 'serviceReservations'));
    })->name('clientReservation');
    
    Route::get('invoice/{reservation}', [invoiceController::class, 'invoice'])->name('invoice');
    
    // Add service routes for authenticated clients
    Route::post('/services/{service}/reserve', [ClientServicesController::class, 'reserve'])->name('client.services.reserve');
    Route::get('/my-service-reservations', [ClientServicesController::class, 'myReservations'])->name('client.services.reservations');

    // Down Payment Payment Routes
    Route::get('/reservations/{reservation}/down-payment', [PaymentController::class, 'showDownPaymentForm'])->name('payment.down.form');
    Route::post('/reservations/{reservation}/pay/paypal', [PaymentController::class, 'payWithPayPal'])->name('payment.paypal');
    Route::get('/reservations/{reservation}/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('payment.paypal.success');
    Route::get('/reservations/{reservation}/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('payment.paypal.cancel');
    Route::post('/reservations/{reservation}/pay/gcash', [PaymentController::class, 'payWithGCash'])->name('payment.gcash');
    Route::post('/reservations/{reservation}/pay/gcash/confirm', [PaymentController::class, 'confirmFakeGCash'])->name('payment.gcash.confirm');
    Route::get('/reservations/{reservation}/gcash/success', [PaymentController::class, 'gcashSuccess'])->name('payment.gcash.success');
    Route::get('/reservations/{reservation}/gcash/cancel', [PaymentController::class, 'gcashCancel'])->name('payment.gcash.cancel');

    // Final Payment Simulation Routes
    Route::get('/reservations/{reservation}/final-payment', [PaymentController::class, 'showFinalPaymentForm'])->name('payment.final.form');
    Route::post('/reservations/{reservation}/pay/final/confirm', [PaymentController::class, 'confirmFakeFinalPayment'])->name('payment.final.confirm');
    // Car Return Simulation Route
    Route::post('/reservations/{reservation}/return', [PaymentController::class, 'returnCar'])->name('reservation.return');
});

Auth::routes();