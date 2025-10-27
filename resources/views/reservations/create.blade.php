@extends('layouts.app')
@section('content')
<h1>Add Reservation</h1>
<form method="POST" action="{{ route('reservations.store') }}">
    @csrf
    <label>Book</label>
    <select name="book_id" required>
        @foreach($books as $book)
            <option value="{{ $book->id }}">{{ $book->title }}</option>
        @endforeach
    </select>
    <label>Student Name</label>
    <input type="text" name="student_name" required>
    <label>Reservation Date</label>
    <input type="date" name="reservation_date" required>
    <button type="submit" class="btn btn-add">Save</button>
</form>
@endsection
