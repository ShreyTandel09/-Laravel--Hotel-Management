@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>

<div class="heatmap-container">
    <h3>Booking Heatmap</h3>
    <div class="heatmap-info">
        <span class="heatmap-legend red"></span> Red: >80% Full |
        <span class="heatmap-legend orange"></span> Orange: >60% Full |
        <span class="heatmap-legend yellow"></span> Yellow: >40% Full
    </div>

    <div class="calendar-grid" id="calendar-grid">
        <!-- Dates will be dynamically injected here -->
    </div>
</div>

<div id="roomSummary">
    <h3>Room Summary</h3>
    <p>Click a date to view room occupancy.</p>
    <div id="summaryDetails">
        <!-- Room summary details will load here -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        loadHeatmap();

        // Handle date click
        $(document).on('click', '.calendar-day', function() {
            var date = $(this).data('date');
            loadRoomSummary(date);
        });
    });

    function loadHeatmap() {
        $.ajax({
            url: "{{ route('dashboard.heatmap') }}",
            type: "GET",
            success: function(data) {
                var calendarGrid = $('#calendar-grid');
                calendarGrid.empty();

                // Loop over each day and append a div with appropriate color
                $.each(data.dates, function(index, day) {
                    calendarGrid.append(`
                        <div class="calendar-day ${day.color}" data-date="${day.date}">
                            <span>${day.date}</span>
                        </div>
                    `);
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function loadRoomSummary(date) {
        $.ajax({
            url: "{{ route('dashboard.roomSummary') }}",
            type: "GET",
            data: {
                date: date
            },
            success: function(data) {
                $('#summaryDetails').html(`
                    <h4>Summary for ${date}</h4>
                    <p>Booked Rooms: ${data.bookedRooms}</p>
                    <p>Empty Rooms: ${data.emptyRooms}</p>
                    <ul>
                        ${data.rooms.map(room => `<li>${room.room_no} - ${room.room_type}</li>`).join('')}
                    </ul>
                `);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

@endsection

<style>
    .heatmap-container {
        margin-top: 20px;
    }

    .heatmap-info {
        margin-bottom: 10px;
    }

    .heatmap-legend {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }

    .heatmap-legend.red {
        background-color: red;
    }

    .heatmap-legend.orange {
        background-color: orange;
    }

    .heatmap-legend.yellow {
        background-color: yellow;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-gap: 5px;
        margin-top: 20px;
    }

    .calendar-day {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        cursor: pointer;
        color: white;
        font-weight: bold;
    }

    .calendar-day.red {
        background-color: red;
    }

    .calendar-day.orange {
        background-color: orange;
    }

    .calendar-day.yellow {
        background-color: yellow;
    }

    .calendar-day:hover {
        opacity: 0.8;
    }
</style>