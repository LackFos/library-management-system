<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function all(Request $request)
    {
        try {
            $keyword = $request->query('search');

            $books = $keyword ? Book::where('title', 'like', '%' . $keyword . '%')->get() : Book::all();

            $message = $books->isEmpty() ? 'Book not found' : 'Book found';
            
            return ResponseHelper::returnOkResponse($message, $books);
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function create(CreateBookRequest $request)
    {
        try {
            $validated = $request->validated();

            $book = Book::create($validated);

            if($request->expectsJson()) {
                return ResponseHelper::returnOkResponse('Book created', $book);
            } else {
                return redirect('/buku/' . $book->id)->with('success', 'Buku berhasil ditambahkan');
            }
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function detail(Book $book)
    {
        try {
            return ResponseHelper::returnOkResponse('Book found successfully', $book);
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $validated = $request->validated();

            $book->update($validated);

            if ($request->expectsJson()) {
                return ResponseHelper::returnOkResponse('Book updated successfully', $book);
            } else {
                return redirect('/buku/' . $book->id)->with('success', 'Buku berhasil diupdate');
            }
        } catch (\Exception $ex) { 
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function delete(Request $request, Book $book)
    {
        try {
            $book->borrowed()->delete();

            $book->delete();

            if($request->expectsJson()) {
                return ResponseHelper::returnOkResponse('Book deleted successfully', $book);
            } else {
                return redirect('/buku')->with('success', 'Buku berhasil dihapus');
            }

        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }
}
