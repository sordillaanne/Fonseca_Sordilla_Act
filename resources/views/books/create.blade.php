@extends('layouts.app')
@section('content')
<h1>Add Book</h1>
<form method="POST" action="{{ route('books.store') }}">
    @csrf
    <label>Title</label>
    <input type="text" name="title" required>
    <label>Author</label>
    <input type="text" name="author" required>
    <label>Copies</label>
    <input type="number" name="copies" min="1" required>
    <button type="submit" class="btn btn-add">Save</button>
</form>
@endsection
