<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>

<div class="heatmap">
    <h3>Booking Heatmap</h3>
    <div class="alert alert-info">Red: >80% Full | Orange: >60% | Yellow: >40%</div>
    <table class="table table-bordered">
        <tr>
            <td style="background-color: red;">1</td>
            <td style="background-color: orange;">2</td>
            <td style="background-color: yellow;">3</td>
            <td>4</td>
        </tr>
    </table>
</div>

<div id="roomSummary">
    <h3>Room Summary</h3>
    <p>Click a date to view room occupancy.</p>
</div>

<div id="vacancies">
    <h3>Vacancies Today</h3>
    <ul class="list-group">
        <li class="list-group-item">Room 101 - Deluxe</li>
        <li class="list-group-item">Room 202 - Luxury</li>
    </ul>
</div>
@endsection