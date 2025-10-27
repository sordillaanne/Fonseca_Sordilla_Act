@extends('layouts.app')
@section('content')
<h1>Edit Reservation</h1>
<form method="POST" action="{{ route('reservations.update', $reservation) }}">
    @csrf @method('PUT')
    <label>Book</label>
    <select name="book_id" required>
        @foreach($books as $book)
            <option value="{{ $book->id }}" @if($reservation->book_id == $book->id) selected @endif>
                {{ $book->title }}
            </option>
        @endforeach
    </select>
    <label>Student Name</label>
    <input type="text" name="student_name" value="{{ $reservation->student_name }}" required>
    <label>Reservation Date</label>
    <input type="date" name="reservation_date" value="{{ $reservation->reservation_date }}" required>
    <button type="submit" class="btn btn-edit">Update</button>
</form>
@endsection
