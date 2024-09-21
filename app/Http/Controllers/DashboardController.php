<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function heatmap()
    {
        // Logic to generate heatmap data
        return response()->json([
            'dates' => [
                ['date' => '2024-09-20', 'color' => 'red'],
                ['date' => '2024-09-21', 'color' => 'orange'],
                // More dates here...
            ]
        ]);
    }

    public function roomSummary(Request $request)
    {
        $date = $request->input('date');
        // Logic to fetch room summary for the given date
        return response()->json([
            'bookedRooms' => 10,
            'emptyRooms' => 5,
            'rooms' => [
                ['room_no' => 101, 'room_type' => 'Deluxe'],
                ['room_no' => 202, 'room_type' => 'Luxury'],
                // More rooms...
            ]
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
