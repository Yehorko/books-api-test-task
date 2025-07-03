<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::withCount('books');

        if ($search = $request->input('search')) {
            $query->where('name', 'ILIKE', "%$search%");
        }

        return $query->get()->map(fn($author) => [
            'name' => $author->name,
            'books_count' => $author->books_count
        ]);
    }

    public function books(Author $author)
    {
        return $author->books()->with('authors')->get()->map(function ($book) {
            return [
                'title' => $book->title,
                'description' => $book->description,
                'authors' => $book->authors->pluck('name'),
                'published' => $book->published
            ];
        });
    }
}