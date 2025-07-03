<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController
{
    public function index(Request $request)
    {
        $query = Book::with('authors');

        if ($search = $request->input('search')) {
            $query->where('title', 'ILIKE', "%$search%")
                ->orWhere('short_description', 'ILIKE', "%$search%")
                ->orWhere('long_description', 'ILIKE', "%$search%")
                ->orWhereHas('authors', fn($q) => $q->where('name', 'ILIKE', "%$search%"));
        }

        return $query->get()->map(function ($book) {
            return [
                'title' => $book->title,
                'short_description' => $book->short_description,
                'long_description' => $book->long_description,
                'authors' => $book->authors->pluck('name'),
                'published' => $book->published,
            ];
        });
    }
}