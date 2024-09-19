<!-- resources/views/rooms/index.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Rooms</h1>

<a href="{{ route('rooms.create') }}" class="btn btn-primary">Add New Room</a>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Room No</th>
            <th>Room Type</th>
            <th>Amenities</th>
            <th>Max Occupancy</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $room)
        <tr>
            <td>{{ $room->room_no }}</td>
            <td>{{ $room->room_type }}</td>
            <td>
                @foreach (json_decode($room->amenities) as $amenity => $value)
                @if ($value) {{ ucfirst($amenity) }} @endif
                @endforeach
            </td>
            <td>{{ $room->max_occupancy }}</td>
            <td><a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection