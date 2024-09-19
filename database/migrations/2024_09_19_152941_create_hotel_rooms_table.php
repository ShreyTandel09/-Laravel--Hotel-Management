<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_no')->unique();
            $table->enum('room_type', ['Deluxe', 'Luxury', 'Royal']);
            $table->json('amenities'); // Stores amenities in JSON format
            $table->integer('max_occupancy');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
