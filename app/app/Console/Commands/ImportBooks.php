<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ImportBooks extends Command
{
    protected $signature = 'books:import';
    protected $description = 'Import books from JSON';

    public function handle(): void
    {
        $url = 'https://raw.githubusercontent.com/bvaughn/infinite-list-reflow-examples/refs/heads/master/books.json';
        $response = Http::get($url);

        $books = $response->json();

        foreach ($books as $data) {
            if (empty($data['isbn'])|| empty($data['publishedDate']['$date'])) {
                continue;
            }
            $book = Book::updateOrCreate(
                ['isbn' => $data['isbn']],
                [
                    'title' => $data['title'],
                    'short_description' => $data['shortDescription'] ?? null,
                    'long_description' => $data['longDescription'] ?? null,
                    'published' => Carbon::parse($data['publishedDate']['$date'])
                ]
            );

            $authorIds = [];
            foreach ($data['authors'] as $name) {
                $author = Author::firstOrCreate(['name' => $name]);
                $authorIds[] = $author->id;
            }

            $book->authors()->sync($authorIds);
        }

        $this->info('Books imported successfully!');
    }
}
