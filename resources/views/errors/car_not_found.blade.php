@extends('layouts.myapp')

@section('content')
<div style="text-align:center; margin-top:100px;">
    <h1>Car Not Found</h1>
    <p>Sorry, the car you are trying to reserve does not exist or is not available.</p>
    <a href="{{ route('cars') }}" style="color: #fff; background: #f39c12; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Back to Cars</a>
</div>
@endsection 