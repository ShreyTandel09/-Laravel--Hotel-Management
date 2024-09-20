<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRooms extends Model
{
    use HasFactory;
    protected $table = 'hotel_rooms';
    protected $fillable = ['room_no', 'room_type', 'amenities', 'max_occupancy'];

    public function rents()
    {
        return $this->hasMany(RoomRents::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
