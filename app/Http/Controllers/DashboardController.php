<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function heatmap()
    {
        // Fetch all bookings with the related rooms
        $bookingData = Booking::with(relations: 'room')->get();

        $occupancyData = [];

        // Iterate over each booking
        foreach ($bookingData as $booking) {
            $startDate = $booking->start_date;
            $maxOccupancy = $booking->room->max_occupancy;

            // Initialize the data for each date if not already done
            if (!isset($occupancyData[$startDate])) {
                $occupancyData[$startDate] = [
                    'total_occupied' => 0, // Number of rooms booked
                    'total_max_capacity' => 0, // Total available occupancy across all rooms
                ];
            }

            // For each booking, increment the total max capacity (room's max occupancy)
            $occupancyData[$startDate]['total_max_capacity'] += $maxOccupancy;
            $occupancyData[$startDate]['total_occupied']++;
        }

        // Calculate occupancy percentage for each date
        foreach ($occupancyData as $date => $data) {
            if ($data['total_max_capacity'] > 0) {
                $occupancyData[$date]['occupancy_percentage'] = ($data['total_occupied'] / $data['total_max_capacity']) * 100;
            } else {
                $occupancyData[$date]['occupancy_percentage'] = 0;
            }
        }

        // dd($occupancyData);

        // Now generate the heatmap colors based on occupancy percentage
        $heatmap = [];
        foreach ($occupancyData as $date => $data) {
            $occupancyPercentage = $data['occupancy_percentage'];

            if ($occupancyPercentage > 80) {
                $color = 'red';
            } elseif ($occupancyPercentage > 60) {
                $color = 'orange';
            } else {
                $color = 'green';
            }

            $heatmap[] = [
                'date' => $date,
                'color' => $color,
            ];
        }

        return response()->json([
            'dates' => $heatmap
        ]);
    }


    public function roomSummary(Request $request)
    {
        $date = $request->input('date');

        // Fetch rooms getting new guests today (check-ins)
        $checkInsToday = Booking::with('room')
            ->where('start_date', $date)
            ->get();

        // Fetch rooms getting vacant today (check-outs)
        $checkOutsToday = Booking::with('room')
            ->where('end_date', $date)
            ->get();

        // Process check-ins
        $checkInRooms = [];
        foreach ($checkInsToday as $booking) {
            $customer = Customer::find($booking->customer_id);

            $checkInRooms[] = [
                'room_no' => $booking->room->room_no,
                'room_type' => $booking->room->room_type,
                'guest' => $customer->name
            ];
        }

        // Process check-outs
        $checkOutRooms = [];
        foreach ($checkOutsToday as $booking) {

            $customer = Customer::find($booking->customer_id);
            $checkOutRooms[] = [
                'room_no' => $booking->room->room_no,
                'room_type' => $booking->room->room_type,
                'guest' => $customer->name
            ];
        }

        // Return response with room summary
        return response()->json([
            'checkInRooms' => $checkInRooms,
            'checkOutRooms' => $checkOutRooms,
        ]);
    }



    public function vacancies()
    {
        // Logic to fetch rooms getting vacant today
        return response()->json([
            'vacancies' => [
                ['room_no' => 101, 'room_type' => 'Deluxe'],
                ['room_no' => 202, 'room_type' => 'Luxury'],
                // More rooms...
            ]
        ]);
    }
}
