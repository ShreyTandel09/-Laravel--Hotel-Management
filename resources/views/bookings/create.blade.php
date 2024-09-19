<!-- resources/views/bookings/create.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Book a Room</h1>

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="customer_name">Customer Name</label>
        <input type="text" name="customer_name" id="customer_name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="customer_email">Customer Email</label>
        <input type="email" name="customer_email" id="customer_email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="room_type">Room Type</label>
        <select name="room_type" id="room_type" class="form-control" required>
            <option value="Deluxe">Deluxe</option>
            <option value="Luxury">Luxury</option>
            <option value="Royal">Royal</option>
        </select>
    </div>

    <div class="form-group">
        <label>Amenities</label><br>
        <label><input type="checkbox" name="amenities[bathtub]" value="1"> Bathtub</label><br>
        <label><input type="checkbox" name="amenities[balcony]" value="1"> Balcony</label><br>
        <label><input type="checkbox" name="amenities[mini_bar]" value="1"> Mini Bar</label>
    </div>

    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="total_cost">Total Cost</label>
        <input type="text" name="total_cost" id="total_cost" class="form-control" readonly>
    </div>

    <button type="submit" class="btn btn-success">Confirm Booking</button>
</form>
@endsection