<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_rooms_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent', 8, 2); // Rent amount
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_rents');
    }
};
