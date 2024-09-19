@extends('layouts.app')

@section('content')
<h1>Manage Room Rents</h1>

<a href="{{ route('room-rents.create') }}" class="btn btn-primary mb-3">Add Room Rent</a>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Rent</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roomRents as $rent)
        <tr>
            <td>{{ $rent->room->room_no }}</td>
            <td>{{ $rent->room->room_type }}</td>
            <td>{{ $rent->start_date }}</td>
            <td>{{ $rent->end_date }}</td>
            <td>${{ number_format($rent->rent, 2) }}</td>
            <td>
                <a href="{{ route('room-rents.edit', $rent->id) }}" class="btn btn-warning">Edit</a>

                <form action="{{ route('room-rents.destroy', $rent->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection