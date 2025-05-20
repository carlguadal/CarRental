@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">User Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">User Details</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user me-1"></i>
            User Information
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Name:</div>
                <div class="col-md-9">{{ $user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email:</div>
                <div class="col-md-9">{{ $user->email }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Phone:</div>
                <div class="col-md-9">{{ $user->phone }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Joined Date:</div>
                <div class="col-md-9">{{ $user->created_at->format('F d, Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Last Updated:</div>
                <div class="col-md-9">{{ $user->updated_at->format('F d, Y') }}</div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-car me-1"></i>
            Reservations History
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Car</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->car->brand }} {{ $reservation->car->model }}</td>
                        <td>{{ $reservation->start_date }}</td>
                        <td>{{ $reservation->end_date }}</td>
                        <td>
                            <span class="badge bg-{{ $reservation->status == 'pending' ? 'warning' : ($reservation->status == 'approved' ? 'success' : 'danger') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td>${{ number_format($reservation->total_price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No reservations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users List</a>
    </div>
</div>
@endsection 