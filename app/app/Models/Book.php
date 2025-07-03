<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $table = 'public.books';
    protected $fillable = ['isbn', 'title', 'description', 'published', 'short_description', 'long_description'];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}