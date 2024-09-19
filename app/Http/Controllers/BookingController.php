<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\HotelRooms;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $rooms = HotelRooms::all(); // Filter rooms based on availability later
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'room_id' => 'required|exists:hotel_rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Create a new customer using validated data
        $customer = Customer::create($validatedData);

        // Find the room
        $room = HotelRooms::find($request->room_id);

        // Calculate total cost
        $totalCost = $this->calculateTotalCost($room, $request->start_date, $request->end_date);

        // Store the booking
        Booking::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking successful!');
    }


    private function calculateTotalCost($room, $startDate, $endDate)
    {
        // Logic to calculate cost based on RoomRent table for the selected dates
        $totalCost = 0;
        // Fetch rent per day and calculate total
        return $totalCost;
    }
}
