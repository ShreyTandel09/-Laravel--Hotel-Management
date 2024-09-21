@extends('layouts.app')

@section('content')
<h1>Edit Room</h1>

<form action="{{ route('rooms.update', $room->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="room_no">Room Number</label>
        <input type="text" name="room_no" id="room_no" class="form-control" value="{{ $room->room_no }}" required>
    </div>

    <div class="form-group">
        <label for="room_type">Room Type</label>
        <input type="text" name="room_type" id="room_type" class="form-control" value="{{ $room->room_type }}" required>
    </div>

    <div class="form-group">
        <label for="amenities">Amenities</label><br>
        <label>
            <input type="checkbox" name="amenities[]" value="bathtub"
                {{ in_array('bathtub', json_decode($room->amenities) ?? []) ? 'checked' : '' }}>
            Bathtub
        </label><br>
        <label>
            <input type="checkbox" name="amenities[]" value="balcony"
                {{ in_array('balcony', json_decode($room->amenities) ?? []) ? 'checked' : '' }}>
            Balcony
        </label><br>
        <label>
            <input type="checkbox" name="amenities[]" value="mini_bar"
                {{ in_array('mini_bar', json_decode($room->amenities) ?? []) ? 'checked' : '' }}>
            Mini Bar
        </label>
    </div>


    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $room->start_date }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $room->end_date }}" required>
    </div>

    <div class="form-group">
        <label for="rent">Room Rent (per night)</label>
        <input type="number" name="rent" id="rent" class="form-control" value="{{ $room->rent }}" step="0.01" required>
    </div>


    <div class="form-group">
        <label for="max_occupancy">Max Occupancy</label>
        <input type="number" name="max_occupancy" id="max_occupancy" class="form-control" value="{{ $room->max_occupancy }}" required>
    </div>

    <button type="submit" class="btn btn-success">Update Room</button>
</form>
@endsection