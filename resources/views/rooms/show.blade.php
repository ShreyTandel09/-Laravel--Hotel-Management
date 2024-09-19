<!-- resources/views/rooms/show.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Room Details</h1>

<p><strong>Room No:</strong> {{ $room->room_no }}</p>
<p><strong>Room Type:</strong> {{ $room->room_type }}</p>
<p><strong>Amenities:</strong>
    @foreach (json_decode($room->amenities) as $amenity => $value)
    @if ($value) {{ ucfirst($amenity) }} @endif
    @endforeach
</p>
<p><strong>Max Occupancy:</strong> {{ $room->max_occupancy }}</p>

<a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back to List</a>
@endsection