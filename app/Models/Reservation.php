<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'student_name', 'reservation_date'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
