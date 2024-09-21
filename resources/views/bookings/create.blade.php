<!-- resources/views/bookings/create.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Book a Room</h1>

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name"> Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email"> Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="phone"> phone</label>
        <input type="phone" name="phone" id="phone" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="room_type">Room Type</label>
        <select name="room_type" id="room_type" class="form-control" required>
            <option value="Deluxe">Deluxe</option>
            <option value="Luxury">Luxury</option>
            <option value="Royal">Royal</option>
        </select>
    </div>
    <div class="form-group">
        <label>Amenities</label><br>
        <label><input type="checkbox" name="amenities[]" value="bathtub"> Bathtub</label><br>
        <label><input type="checkbox" name="amenities[]" value="balcony"> Balcony</label><br>
        <label><input type="checkbox" name="amenities[]" value="mini_bar"> Mini Bar</label>
    </div>

    <div class="form-group">
        <label for="room_no">Room Number</label>
        <select name="room_no" id="room_no" class="form-control" required>
            <option value="">Select a room</option>
        </select>
    </div>

    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="total_cost">Total Cost</label>
        <input type="text" name="total_cost" id="total_cost" class="form-control" readonly>
    </div>

    <button type="submit" class="btn btn-success">Confirm Booking</button>
</form>

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('input[name="amenities[]"],#start_date, #end_date, #room_type').change(function() {
            var roomType = $('#room_type').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var amenities = $('input[name="amenities[]"]:checked').map(function() {
                return $(this).val(); // Get the value of each checked checkbox
            }).get();

            console.log(amenities);

            // AJAX request
            $.ajax({
                url: "{{ route('rooms.available') }}",
                type: "POST",
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    room_type: roomType,
                    amenities: amenities,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    var roomSelect = $('#room_no');
                    roomSelect.empty(); // Clear existing options

                    if (data.length > 0) {
                        $.each(data, function(index, room) {
                            roomSelect.append($('<option>', {
                                value: room.id,
                                text: room.room_no
                            }));
                        });
                    } else {
                        roomSelect.append($('<option>', {
                            value: '',
                            text: 'No rooms available'
                        }));
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#start_date, #end_date, #room_type').change(function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var roomType = $('#room_type').val();
            var roomNo = $('#room_no').val();

            // Make AJAX call to calculate total cost
            $.ajax({
                url: "{{ route('calculate.cost') }}",
                type: "POST",
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    room_type: roomType,
                    room_no: roomNo,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#total_cost').val(response.total_cost); // Update total cost field
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>