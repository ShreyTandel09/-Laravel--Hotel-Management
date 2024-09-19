<?php

namespace App\Http\Controllers;

use App\Models\HotelRooms;
use App\Models\RoomRents;
use Illuminate\Http\Request;

class RoomRentsController extends Controller
{
    public function index()
    {
        // Get all room rents
        $roomRents = RoomRents::with('room')->get();
        return view('room_rents.index', compact('roomRents'));
    }

    public function create()
    {
        // Get all rooms
        $rooms = HotelRooms::all();
        return view('room_rents.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent' => 'required|numeric|min:0',
        ]);

        // Create new room rent
        RoomRents::create($validated);

        return redirect()->route('room-rents.index')->with('success', 'Room Rent added successfully.');
    }

    public function edit($id)
    {
        $roomRent = RoomRents::findOrFail($id);
        $rooms = HotelRooms::all();
        return view('room_rents.edit', compact('roomRent', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent' => 'required|numeric|min:0',
        ]);

        // Update room rent
        $roomRent = RoomRents::findOrFail($id);
        $roomRent->update($validated);

        return redirect()->route('room-rents.index')->with('success', 'Room Rent updated successfully.');
    }

    public function destroy($id)
    {
        // Delete room rent
        $roomRent = RoomRents::findOrFail($id);
        $roomRent->delete();

        return redirect()->route('room-rents.index')->with('success', 'Room Rent deleted successfully.');
    }
}
