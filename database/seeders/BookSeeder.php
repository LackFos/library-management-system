<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book = Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'isbn' => '9780743270755',
            'image' => '/storage/images/harry_potter.png',
            'publisher' => 'Scribner',
            'publication_date' => '1925-04-10',
            'stock' => 5,
            'description' => 'Test'
        ]);
        
        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'isbn' => '9780061120084',
            'publisher' => 'J.B. Lippincott & Co.',
            'publication_date' => '1960-07-11',
            'stock' => 10,
            'description' => 'A novel about the serious issues of rape and racial inequality.'
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'isbn' => '9780451524935',
            'publisher' => 'Secker & Warburg',
            'publication_date' => '1949-06-08',
            'stock' => 15,
            'description' => 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.'
        ]);

        Book::create([
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'isbn' => '9780547928227',
            'publisher' => 'George Allen & Unwin',
            'publication_date' => '1937-09-21',
            'stock' => 12,
            'description' => 'A fantasy novel and children\'s book that sets the stage for The Lord of the Rings.'
        ]);
    }
}
