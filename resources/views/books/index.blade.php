@extends('layouts.app')
@section('content')
<h1>Books</h1>
<a href="{{ route('books.create') }}" class="btn btn-add">Add Book</a>
<table>
    <tr><th>Title</th><th>Author</th><th>Copies</th><th>Actions</th></tr>
    @foreach($books as $book)
    <tr>
        <td>{{ $book->title }}</td>
        <td>{{ $book->author }}</td>
        <td>{{ $book->copies }}</td>
        <td>
            <a href="{{ route('books.edit', $book) }}" class="btn btn-edit">Edit</a>
            <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
