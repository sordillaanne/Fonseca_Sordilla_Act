@extends('layouts.app')
@section('content')
<h1>Edit Book</h1>
<form method="POST" action="{{ route('books.update', $book) }}">
    @csrf @method('PUT')
    <label>Title</label>
    <input type="text" name="title" value="{{ $book->title }}" required>
    <label>Author</label>
    <input type="text" name="author" value="{{ $book->author }}" required>
    <label>Copies</label>
    <input type="number" name="copies" value="{{ $book->copies }}" min="1" required>
    <button type="submit" class="btn btn-edit">Update</button>
</form>
@endsection
