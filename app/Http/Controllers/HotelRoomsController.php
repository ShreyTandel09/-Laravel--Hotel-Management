<?php

namespace App\Http\Controllers;

use App\Models\HotelRooms;
use Illuminate\Http\Request;

class HotelRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = HotelRooms::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'room_no' => 'required|integer',
            'room_type' => 'required|string',
            'amenities' => 'nullable|array',
            'max_occupancy' => 'required|integer',
        ]);

        // Convert amenities array to JSON
        $amenities = json_encode($request->amenities);

        // Create a new room
        HotelRooms::create([
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'amenities' => $amenities, // Storing JSON encoded amenities
            'max_occupancy' => $request->max_occupancy,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }


    public function show($id)
    {
        $room = HotelRooms::find($id);
        return view('rooms.show', compact('room'));
    }
}
