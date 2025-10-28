# Library Reservation System

## Description / Overview

The **Library Reservation System** is a comprehensive web-based application developed as part of the midterm examination project. This system streamlines the process of reserving library resources including books, study rooms, and computer workstations within an educational or public library setting. Built using modern web technologies with Laravel framework, it provides an intuitive interface for library staff and patrons to manage reservations, track availability, and maintain library resources efficiently.

The application demonstrates the practical implementation of CRUD (Create, Read, Update, Delete) operations, database management, user authentication, and real-time availability checking within a real-world library management context.

## Objectives

The main goals and learning outcomes of this midterm project include:

- **Database Design & Implementation** — Develop a normalized relational database schema for managing library resources, users, and reservations
- **Full-Stack Development Skills** — Apply knowledge of both frontend and backend technologies to create a functional web application using Laravel
- **User Authentication & Authorization** — Implement secure login systems with role-based access control for librarians and patrons
- **Reservation Management** — Demonstrate proficiency in handling booking systems with date/time validation and conflict prevention
- **CRUD Operations Mastery** — Create, read, update, and delete operations for resources, users, and reservations
- **Form Validation** — Apply client-side and server-side validation techniques to ensure data integrity and prevent booking conflicts
- **Responsive Design** — Create a user-friendly interface that works across different devices and screen sizes
- **Code Organization** — Practice clean code principles and follow MVC (Model-View-Controller) architecture patterns

## Features / Functionality

### Core Features

- **Resource Management**
  - Add, edit, and delete library resources (books, study rooms, workstations)
  - Track resource availability in real-time
  - Categorize resources by type, location, and capacity
  - Upload and manage resource images and descriptions
  
- **Reservation System**
  - Book library resources for specific date and time slots
  - View available time slots before making reservations
  - Automatic conflict detection to prevent double-booking
  - Reservation confirmation and cancellation
  - Set maximum reservation duration and advance booking limits

- **User Management**
  - Register and manage patron accounts
  - Librarian and admin user roles
  - View user reservation history
  - Track patron borrowing limits and penalties

- **Search & Filter**
  - Search resources by title, author, category, or ID
  - Filter available resources by date, time, and type
  - Advanced search with multiple criteria
  - View resource details and reservation calendar

- **Reservation Tracking**
  - View current, upcoming, and past reservations
  - Email notifications for reservation confirmations
  - Overdue and pending reservation alerts
  - Generate reservation reports

- **User Authentication**
  - Secure login system with encrypted passwords
  - Role-based access (Admin, Librarian, Patron)
  - Session management and logout functionality
  - Password reset functionality

- **Dashboard & Reports**
  - Administrative dashboard with reservation statistics
  - Most reserved resources analytics
  - Generate reports for resource utilization
  - Export reservation data to CSV or PDF formats

## Installation Instructions

Follow these steps to set up and run the project on your local machine:

### Prerequisites

- PHP 8.1 or higher
- Composer (Dependency Manager for PHP)
- MySQL 8.0 or higher
- Node.js and npm (for frontend assets)
- Web server (Apache or Nginx)

### Step-by-Step Installation

1. **Clone the Repository**
```bash
   git clone https://github.com/yourusername/library-reservation.git
   cd library-reservation
```

2. **Install PHP Dependencies**
```bash
   composer install
```

3. **Install Node Dependencies**
```bash
   npm install
```

4. **Environment Configuration**
```bash
   cp .env.example .env
   php artisan key:generate
```

5. **Database Setup**
   
   Edit the `.env` file with your database credentials:
```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_reservation_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
```

6. **Run Database Migrations**
```bash
   php artisan migrate
```

7. **Seed the Database (Optional)**
```bash
   php artisan db:seed
```

8. **Build Frontend Assets**
```bash
   npm run dev
```

9. **Start the Development Server**
```bash
   php artisan serve
```

10. **Access the Application**
    
    Open your browser and navigate to: `http://localhost:8000`

### Default Login Credentials

- **Admin Account**
  - Email: admin@library.com
  - Password: admin123

- **Librarian Account**
  - Email: librarian@library.com
  - Password: librarian123

- **Patron Account**
  - Email: patron@library.com
  - Password: patron123

## Usage

### For Administrators

1. **Managing Resources**
   - Navigate to the "Resources" menu
   - Click "Add New Resource" to create a resource record
   - Select resource type (Book, Study Room, Computer Workstation)
   - Fill in required fields (Title/Name, Category, Location, Availability)
   - Upload resource image if applicable
   - Click "Save" to add the resource to the database
   - Use filters to find specific resources
   - Click "Edit" or "Delete" buttons to modify or remove records

2. **Managing Users**
   - Go to "Users" → "All Users"
   - View list of registered patrons and staff
   - Edit user roles and permissions
   - Activate or deactivate user accounts
   - View user reservation history

3. **Viewing Reports**
   - Access "Reports" from the dashboard
   - Generate reservation statistics by date range
   - View most popular resources
   - Export data for analysis

### For Librarians

1. **Processing Reservations**
   - View all current and upcoming reservations
   - Approve or reject pending reservations
   - Mark reservations as completed or cancelled
   - Handle walk-in reservations for patrons

2. **Managing Resource Availability**
   - Update resource status (Available, Reserved, Maintenance)
   - Set special operating hours or closures
   - View real-time availability calendar

### For Patrons

1. **Making a Reservation**
   - Log in to the patron portal
   - Browse or search for available resources
   - Select desired resource and click "Reserve"
   - Choose date and time slot
   - Confirm reservation details
   - Receive confirmation email

2. **Managing My Reservations**
   - Navigate to "My Reservations"
   - View active, upcoming, and past reservations
   - Cancel reservations if needed
   - Extend reservation if allowed

3. **Searching Resources**
   - Use the search bar on the homepage
   - Filter by category, availability, or location
   - View detailed information about resources
   - Check availability calendar before booking

## Screenshots or Code Snippets

### Resource Model Example
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'resource_type',
        'category',
        'location',
        'capacity',
        'description',
        'image_url',
        'status'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAvailable($date, $startTime, $endTime)
    {
        return !$this->reservations()
            ->where('reservation_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function getAvailableTimeSlots($date)
    {
        $allSlots = $this->generateTimeSlots();
        $reservedSlots = $this->reservations()
            ->where('reservation_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get();

        return array_filter($allSlots, function ($slot) use ($reservedSlots) {
            return !$this->isSlotReserved($slot, $reservedSlots);
        });
    }
}
```

### Reservation Model Example
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'resource_id',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'purpose',
        'notes'
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function isPast()
    {
        return $this->reservation_date < now()->toDateString();
    }

    public function isActive()
    {
        return $this->status === 'confirmed' && 
               $this->reservation_date >= now()->toDateString();
    }

    public function canBeCancelled()
    {
        return $this->status === 'confirmed' && 
               $this->reservation_date >= now()->toDateString();
    }
}
```

### Reservation Controller CRUD Operations
```php
<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'resource'])
            ->where('user_id', Auth::id())
            ->orderBy('reservation_date', 'desc')
            ->paginate(10);
        
        return view('reservations.index', compact('reservations'));
    }

    public function create($resourceId)
    {
        $resource = Resource::findOrFail($resourceId);
        return view('reservations.create', compact('resource'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'nullable|string|max:500'
        ]);

        // Check availability
        $resource = Resource::findOrFail($validated['resource_id']);
        
        if (!$resource->isAvailable(
            $validated['reservation_date'],
            $validated['start_time'],
            $validated['end_time']
        )) {
            return back()->withErrors([
                'time_slot' => 'This time slot is not available.'
            ])->withInput();
        }

        // Create reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $validated['resource_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose' => $validated['purpose'],
            'status' => 'confirmed'
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully!');
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if (!$reservation->canBeCancelled()) {
            return back()->withErrors([
                'reservation' => 'This reservation cannot be cancelled.'
            ]);
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully!');
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully!');
    }
}
```

### Database Migration Example
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('resource_type', ['book', 'study_room', 'computer']);
            $table->string('category');
            $table->string('location');
            $table->integer('capacity')->default(1);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['available', 'reserved', 'maintenance'])
                  ->default('available');
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('resource_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('confirmed');
            $table->string('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['resource_id', 'reservation_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('resources');
    }
};
```

### Sample Reservation Form (Blade Template)
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reserve {{ $resource->title }}</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5>Resource Details</h5>
            <p><strong>Type:</strong> {{ ucfirst($resource->resource_type) }}</p>
            <p><strong>Location:</strong> {{ $resource->location }}</p>
            <p><strong>Capacity:</strong> {{ $resource->capacity }} person(s)</p>
        </div>
    </div>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="resource_id" value="{{ $resource->id }}">
        
        <div class="form-group">
            <label for="reservation_date">Reservation Date</label>
            <input type="date" 
                   class="form-control @error('reservation_date') is-invalid @enderror" 
                   id="reservation_date" 
                   name="reservation_date" 
                   value="{{ old('reservation_date') }}" 
                   min="{{ date('Y-m-d') }}"
                   required>
            @error('reservation_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" 
                           class="form-control @error('start_time') is-invalid @enderror" 
                           id="start_time" 
                           name="start_time" 
                           value="{{ old('start_time') }}" 
                           required>
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" 
                           class="form-control @error('end_time') is-invalid @enderror" 
                           id="end_time" 
                           name="end_time" 
                           value="{{ old('end_time') }}" 
                           required>
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @error('time_slot')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="purpose">Purpose (Optional)</label>
            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                      id="purpose" 
                      name="purpose" 
                      rows="3">{{ old('purpose') }}</textarea>
            @error('purpose')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Confirm Reservation</button>
        <a href="{{ route('resources.show', $resource) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
    // Check availability when date/time changes
    document.querySelectorAll('#reservation_date, #start_time, #end_time').forEach(input => {
        input.addEventListener('change', checkAvailability);
    });

    function checkAvailability() {
        const date = document.getElementById('reservation_date').value;
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;

        if (date && startTime && endTime) {
            // AJAX call to check availability
            fetch(`/api/resources/{{ $resource->id }}/check-availability`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ date, start_time: startTime, end_time: endTime })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.available) {
                    alert('This time slot is not available. Please choose another time.');
                }
            });
        }
    }
</script>
@endpush
@endsection
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


