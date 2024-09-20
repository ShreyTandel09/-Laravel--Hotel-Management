@extends('layouts.app')

@section('content')
<h1>Room List</h1>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Add Room</a>

<table class="table">
    <thead>
        <tr>
            <th>Room No</th>
            <th>Room Type</th>
            <th>Max Occupancy</th>
            <th>Rent</th>
            <th>Amenities</th>
            <th>Start Date</th>
            <th>End Date</th>

            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $room)
        <tr>
            <td>{{ $room->room_no }}</td>
            <td>{{ $room->room_type }}</td>
            <td>{{ $room->max_occupancy }}</td>
            <td>{{ $room->rent }}</td>
            <td>
                @if($room->amenities)
                @foreach(json_decode($room->amenities) as $amenity => $enabled)
                @if ($enabled)
                {{ ucfirst($amenity) }}
                @endif
                @endforeach
                @else
                No Amenities
                @endif
            </td>
            <td>{{ $room->start_date }}</td>
            <td>{{ $room->end_date }}</td>

            <td>
                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">Edit</a>

                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection