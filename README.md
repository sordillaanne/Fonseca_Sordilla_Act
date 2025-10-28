# 📚 Library Reservation System

## Description / Overview

**LibraryReservation** is a web-based application developed as part of our Midterm Examination.  
The system aims to streamline the process of reserving books and study spaces in the library.  
It allows students and faculty to conveniently check book availability, make reservations, and manage library resources through an intuitive interface. 

## Objectives

- To design and develop a functional **library reservation system**.  
- To apply CRUD operations in managing library resources and reservations.  
- To implement **user authentication and role management** (e.g., Admin and Student).  
- To practice database integration and relational table design.  
- To enhance understanding of web system workflows using Laravel.  

## ⚙️ Features / Functionality
- **User Registration and Login** — secure authentication for library users and administrators.  
- **Book Management** — add, edit, delete, and view available books.  
- **Reservation System** — users can reserve books or library rooms.  
- **Search Functionality** — quickly find books by title, author, or category.  
- **Reservation History** — view current and past reservations.  
- **Admin Dashboard** — manage users, books, and reservations in one place.  
- **Database Integration** using **MySQL**. 

## Installation Instructions
1. **Download or Clone the Project**
   - Download the ZIP file or clone the repository using (the repository of ACT 1):
     ```bash
      git clone https://github.com/sordillaanne/Fonseca_Sordilla_Act
     ```

2. **Move the Project Folder**
   - Extract or copy the project folder into the `htdocs` directory of your **XAMPP** installation.  
     Example path:  
     ```
     C:\xampp\htdocs\LibraryReservation
     ```

3. **Start XAMPP Services**
   - Open the **XAMPP Control Panel**.  
   - Start **Apache** and **MySQL** modules.

4. **Set Up the Database**
   - Open your browser and go to:  
     ```
     http://localhost/phpmyadmin
     ```
   - Create a new database named:  
     ```
     LibraryReservation
     ```
   - Import the provided SQL file (e.g., `LibraryReservation.sql`) into this database.

5. **Configure Database Connection**
   - Open the project’s configuration file (e.g., `dbconnect.php` or `connection.php`).
   - Make sure the following settings match your local environment:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "LibraryReservation";
     ```

6. **Run the Project**
   - Open your web browser and navigate to:
     ```
     http://127.0.0.1:8000/dashboard
     ```
   - The system’s dashboard should now be accessible and the system is ready to use.

## Usage

1. **Access the System**
   - Open your browser and go to:
     ```
     http://127.0.0.1:8000/dashboard
     ```

2. **Add a Book**
-Navigate to the “Add Book” section.
-Fill in the book’s details (e.g., title, author, genre, ISBN, and publication year).
-Click Save to store the book record in the database.

3. **Add a Member**
-Go to the “Add Member” section.
-Enter the member’s details, including their name, contact number, and email address.
-Click Save to register the member in the system.

4. **Reserve a Book**
-Open the “Add Reservation” page.
-Select an existing member and book from the dropdown lists.
-Specify the reservation date and return date.
-Click Submit to confirm the reservation.

5. **View or Update Records**
-Each module (Books, Members, Reservations, Payments/Fines) allows you to view, edit, or delete existing records using the provided action buttons.

6. **Switch Themes**
-Toggle between Light Mode and Dark Mode using the theme switcher in the interface for better visibility and user comfort.


## Screenshots or Code Snippets

### BookController
```
<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'copies' => 'required|integer|min:1'
        ]);

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'copies' => 'required|integer|min:1'
        ]);

        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
```

### ReservationController
```
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
```

## Contributors

- **Rhissa Anne Sordilla**
  - Developer of the LibraryReservation System
  - BS Information Technology Student
  - Don Mariano Marcos Memorial State University - MLUC

- **Kenneth Fonseca**
  - Project Partner
  - BS Information Technology Student
  - Don Mariano Marcos Memorial State University - MLUC
  

## License

This project is licensed under the **Educational Purposes Only**.
