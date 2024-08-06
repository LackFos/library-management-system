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
            'image' => 'https://cdn2.penguin.com.au/covers/400/9781785151552.jpg',
            'publisher' => 'J.B. Lippincott & Co.',
            'publication_date' => '1960-07-11',
            'stock' => 10,
            'description' => 'A novel about the serious issues of rape and racial inequality.'
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'isbn' => '9780451524935',
            'image' => 'https://thumbs.readings.com.au/3mNjlGJB6zhH-U72e_POqpSPZP0=/0x500/https://readings-v4-production.s3.amazonaws.com/assets/1b7/a16/f4a/1b7a16f4a39f392cebbf097002a0d096f2bd0bb8/978014103614420210513-4-1mhh56c.jpg',
            'publisher' => 'Secker & Warburg',
            'publication_date' => '1949-06-08',
            'stock' => 15,
            'description' => 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.'
        ]);

        Book::create([
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'isbn' => '9780547928227',
            'image' => 'https://i5.walmartimages.com/seo/Lord-of-the-Rings-The-Hobbit-Graphic-Novel-Paperback_663b1072-039c-4791-abe6-da4907097d67.b9d2dc96d22c02f55c2d08f2dba3a11b.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF',
            'publisher' => 'George Allen & Unwin',
            'publication_date' => '1937-09-21',
            'stock' => 12,
            'description' => 'A fantasy novel and children\'s book that sets the stage for The Lord of the Rings.'
        ]);
    }
}
