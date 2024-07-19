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
            /** @var User $user */
            $user = auth()->user();

            if(!$user->hasRole('admin')) {
                return ResponseHelper::throwUnauthorizedError('Only admin can create book');
            }

            $validated = $request->validated();

            $book = Book::create($validated);

            return ResponseHelper::returnOkResponse('Book created', $book);
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

            return ResponseHelper::returnOkResponse('Book updated successfully', $book);
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function delete(Book $book)
    {
        try {
            $book->borrowed()->delete();

            $book->delete();

            return ResponseHelper::returnOkResponse('Book deleted successfully', $book);
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }
}
