@extends('layouts.app')

@section('content')
<h1>Add Room Rent</h1>

<form action="{{ route('room-rents.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="room_id">Room</label>
        <select name="room_id" id="room_id" class="form-control" required>
            @foreach ($rooms as $room)
            <option value="{{ $room->id }}">{{ $room->room_no }} - {{ $room->room_type }}</option>
            @endforeach
        </select>
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

    <button type="submit" class="btn btn-success">Add Rent</button>
</form>
@endsection