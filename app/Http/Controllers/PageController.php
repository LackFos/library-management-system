<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function bookList(Request $request) {
        $query = Book::query();
        
        $keyword = $request->query('search');
        
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%')->orWhere('isbn', $keyword);
        } 

        $books = $query->get(); 

        return view('pages.book-list', compact('books', 'keyword'));
    }

    public function bookDetail(Book $book) {
        return view('pages.book-detail', compact('book'));
    }

    public function cart() {
        return view('pages.cart');
    }

    public function login() {
        return view('pages.login');
    }
}
