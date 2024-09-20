<!-- resources/views/rooms/create.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Add New Room</h1>

<form action="{{ route('rooms.store') }}" method="POST" class="mt-4">
    @csrf
    <div class="form-group">
        <label for="room_no">Room No</label>
        <input type="text" name="room_no" id="room_no" class="form-control" required>
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
        <label><input type="checkbox" name="amenities[]" value="bathtub"> Bathtub</label><br>
        <label><input type="checkbox" name="amenities[]" value="balcony"> Balcony</label><br>
        <label><input type="checkbox" name="amenities[]" value="mini_bar"> Mini Bar</label>
    </div>

    <div class="form-group">
        <label for="max_occupancy">Max Occupancy</label>
        <input type="number" name="max_occupancy" id="max_occupancy" class="form-control" required>
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
        <label for="rent">Room Rent (per night)</label>
        <input type="number" name="rent" id="rent" class="form-control" step="0.01" required>
    </div>

    <button type="submit" class="btn btn-success">Add Room</button>
</form>
@endsection