<!-- resources/views/rooms/create.blade.php -->
<form action="{{ route('rooms.store') }}" method="POST">
    @csrf
    <label for="room_no">Room Number</label>
    <input type="text" name="room_no" required>

    <label for="room_type">Room Type</label>
    <select name="room_type" required>
        <option value="Deluxe">Deluxe</option>
        <option value="Luxury">Luxury</option>
        <option value="Royal">Royal</option>
    </select>

    <label for="amenities">Amenities</label>
    <input type="checkbox" name="amenities[bathtub]" value="1"> Bathtub
    <input type="checkbox" name="amenities[balcony]" value="1"> Balcony
    <input type="checkbox" name="amenities[mini_bar]" value="1"> Mini Bar

    <label for="max_occupancy">Max Occupancy</label>
    <input type="number" name="max_occupancy" required>

    <button type="submit">Add Room</button>
</form>