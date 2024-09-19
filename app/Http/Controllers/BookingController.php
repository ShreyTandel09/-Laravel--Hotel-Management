<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\HotelRooms;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {

        // dd("here");
        $bookings = Booking::with('customer', 'room')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = HotelRooms::all(); // Filter rooms based on availability later
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        try {

            // dd($request->all());
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                // 'room_id' => 'required|exists:rooms,id',
            ]);

            // dd($validatedData);

            // Create a new customer using validated data
            $customer = Customer::create($validatedData);

            // Find the room
            $room = HotelRooms::find(1);

            // dd($room);

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
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Booking failed.'])->withInput();
        }
    }

    public function show($id)
    {
        $booking = Booking::with('customer', 'room')->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with('customer', 'room')->findOrFail($id);
        $rooms = HotelRooms::all(); // For selecting room again if needed
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Booking::findOrFail($id);
        $customer = Customer::findOrFail($booking->customer_id);

        // Update customer and booking details
        $customer->update($validatedData);
        $booking->update([
            'room_id' => $validatedData['room_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'total_cost' => $this->calculateTotalCost(HotelRooms::find($validatedData['room_id']), $validatedData['start_date'], $validatedData['end_date']),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }

    private function calculateTotalCost($room, $startDate, $endDate)
    {
        // Logic to calculate cost based on RoomRent table for the selected dates
        $totalCost = 0;
        // Fetch rent per day and calculate total
        return $totalCost; // Adjust this according to your logic
    }
}
