<!-- resources/views/bookings/create.blade.php -->
<form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
    @csrf
    <label for="name">Customer Name</label>
    <input type="text" name="name" required>

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="start_date">Start Date</label>
    <input type="date" name="start_date" id="startDate" required>

    <label for="end_date">End Date</label>
    <input type="date" name="end_date" id="endDate" required>

    <label for="room_type">Room Type</label>
    <select name="room_type" id="roomType" required>
        <option value="Deluxe">Deluxe</option>
        <option value="Luxury">Luxury</option>
        <option value="Royal">Royal</option>
    </select>

    <label for="amenities">Amenities</label>
    <input type="checkbox" name="amenities[bathtub]" value="1"> Bathtub
    <input type="checkbox" name="amenities[balcony]" value="1"> Balcony
    <input type="checkbox" name="amenities[mini_bar]" value="1"> Mini Bar

    <div id="roomSelection">
        <!-- AJAX-based room selection will populate here -->
    </div>

    <label for="total_cost">Total Cost</label>
    <input type="text" name="total_cost" id="totalCost" readonly>

    <button type="submit">Book Room</button>
</form>

<script>
    $('#roomType, #startDate, #endDate').on('change', function() {
        // AJAX to fetch available rooms based on room type, start date, and end date
    });
</script>