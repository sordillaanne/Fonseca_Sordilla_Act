<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('book')->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $books = Book::all();
        return view('reservations.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_name' => 'required',
            'reservation_date' => 'required|date'
        ]);

        Reservation::create($request->all());
        return redirect()->route('reservations.index')->with('success', 'Reservation added successfully.');
    }

    public function edit(Reservation $reservation)
    {
        $books = Book::all();
        return view('reservations.edit', compact('reservation', 'books'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_name' => 'required',
            'reservation_date' => 'required|date'
        ]);

        $reservation->update($request->all());
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
