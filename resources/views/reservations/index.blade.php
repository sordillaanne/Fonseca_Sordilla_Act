@extends('layouts.app')
@section('content')
<h1>Reservations</h1>
<a href="{{ route('reservations.create') }}" class="btn btn-add">Add Reservation</a>
<table>
    <tr><th>Book</th><th>Student</th><th>Date</th><th>Actions</th></tr>
    @foreach($reservations as $reservation)
    <tr>
        <td>{{ $reservation->book->title }}</td>
        <td>{{ $reservation->student_name }}</td>
        <td>{{ $reservation->reservation_date }}</td>
        <td>
            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-edit">Edit</a>
            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
