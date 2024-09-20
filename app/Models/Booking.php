<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'room_id', 'start_date', 'end_date', 'total_cost', 'hotel_rooms_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(HotelRooms::class, 'hotel_rooms_id'); // Ensure 'room_id' is the correct foreign key
    }
}
