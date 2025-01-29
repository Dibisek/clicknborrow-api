<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'books_categories');
    }
}
