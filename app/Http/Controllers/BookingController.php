<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\HotelRooms;
use App\Models\RoomRents;
use DateTime;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
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


            // Create a new customer using validated data
            $customer = Customer::create($validatedData);

            // dd($request->room_no);

            // Find the room
            $room = HotelRooms::findOrFail($request->room_no);

            // dd($room->id);  

            // Store the booking
            Booking::create([
                'customer_id' => $customer->id,
                'hotel_rooms_id' => $room->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_cost' => $request->total_cost,
            ]);

            return redirect()->route('bookings.index')->with('success', 'Booking successful!');
        } catch (\Throwable $th) {
            dd($th);
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

    public function calculateCost(Request $request)
    {

        // dd($request->all());
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $roomType = $request->input('room_type');
        $roomNo = $request->input('room_no');


        // Define cost per night
        $costPerNight = RoomRents::where('hotel_rooms_id', $roomNo)->pluck("rent");

        // dd($costPerNight[0]);

        // Validate dates
        if ($startDate && $endDate) {
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $interval = $start->diff($end);

            if ($interval->days >= 0) {
                $totalCost = $interval->days * ($costPerNight[0] ?? 0);
                return response()->json(['total_cost' => $totalCost]);
            }
        }
    }
}
