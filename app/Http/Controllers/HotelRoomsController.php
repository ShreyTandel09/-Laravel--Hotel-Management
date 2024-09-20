<?php

namespace App\Http\Controllers;

use App\Models\HotelRooms;
use App\Models\RoomRents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = HotelRooms::select('hotel_rooms.*', 'room_rents.rent', 'room_rents.start_date', 'room_rents.end_date')
            ->leftJoin('room_rents', 'hotel_rooms.id', '=', 'room_rents.hotel_rooms_id')
            ->get();
        return view('rooms.index', compact('rooms'));
    }


    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {

        // $this->validateRoomData($request);   // Validation moved to a helper method
        // dd(json_encode($request->all()));

        // Use Eloquent relationships for clean data handling
        $hotelRoom = HotelRooms::create([
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'amenities' => json_encode($request->amenities),
            'max_occupancy' => $request->max_occupancy,
        ]);

        $hotelRoom->rents()->create([
            'rent' => $request->rent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }


    public function show($id)
    {
        $room = HotelRooms::with('rent')->findOrFail($id);
        return view('rooms.show', compact('room'));
    }


    public function edit($id)
    {
        $room = HotelRooms::select('hotel_rooms.*', 'room_rents.rent', 'room_rents.start_date', 'room_rents.end_date')
            ->leftJoin('room_rents', 'hotel_rooms.id', '=', 'room_rents.hotel_rooms_id')
            ->where('hotel_rooms.id', $id)
            ->first(); // Fetch single room       
        return view('rooms.edit', compact('room'));
    }


    public function update(Request $request, $id)
    {
        $this->validateRoomData($request); // Validation moved to a helper method

        $hotelRoom = HotelRooms::findOrFail($id);

        // Update room details
        $hotelRoom->update([
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'amenities' => json_encode($request->amenities),
            'max_occupancy' => $request->max_occupancy,
        ]);

        // Update or create room rent
        $hotelRoom->rents()->updateOrCreate(
            ['hotel_rooms_id' => $hotelRoom->id],
            [
                'rent' => $request->rent,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        );

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }


    public function destroy($id)
    {
        $room = HotelRooms::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    /**
     * Validate room data.
     */
    private function validateRoomData(Request $request)
    {
        $request->validate([
            'room_no' => 'required|integer',
            'room_type' => 'required|string',
            'amenities' => 'nullable|array',
            'max_occupancy' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent' => 'required|numeric|min:0',
        ]);
    }


    public function getAvailableRooms(Request $request)
    {
        $roomType = $request->input('room_type');
        $amenities = $request->input('amenities', []);

        // Fetch rooms based on room type and selected amenities
        $rooms = HotelRooms::where('room_type', $roomType)
            ->where(function ($query) use ($amenities) {
                foreach ($amenities as $amenity) {
                    // Search for each amenity in the JSON array
                    $query->orWhereRaw('JSON_CONTAINS(amenities, \'["' . $amenity . '"]\')');
                }
            })
            ->get();

        return response()->json($rooms);
    }
}
