@extends('layouts.app')

@section('content')
<h1>Booking Details</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Customer Information</h5>
        <p>Name: {{ $booking->customer->name }}</p>
        <p>Email: {{ $booking->customer->email }}</p>
        <p>Phone: {{ $booking->customer->phone }}</p>

        <h5 class="card-title">Room Information</h5>
        <p>Room Number: {{ $booking->room->room_no }}</p>
        <p>Room Type: {{ $booking->room->room_type }}</p>

        <h5 class="card-title">Booking Details</h5>
        <p>Start Date: {{ $booking->start_date }}</p>
        <p>End Date: {{ $booking->end_date }}</p>
        <p>Total Cost: ${{ number_format($booking->total_cost, 2) }}</p>
    </div>
</div>

<a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
@endsection