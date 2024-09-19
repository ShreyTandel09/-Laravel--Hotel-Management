@extends('layouts.app')

@section('content')
<h1>Edit Booking</h1>

<form action="{{ route('bookings.update', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $booking->customer->name }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $booking->customer->email }}" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $booking->customer->phone }}" required>
    </div>

    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $booking->start_date }}" required>
    </div>

    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $booking->end_date }}" required>
    </div>

    <div class="form-group">
        <label for="room_id">Room</label>
        <select name="room_id" id="room_id" class="form-control" required>
            @foreach($rooms as $room)
            <option value="{{ $room->id }}" {{ $room->id == $booking->room_id ? 'selected' : '' }}>
                {{ $room->room_no }} ({{ $room->room_type }})
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Booking</button>
</form>
@endsection