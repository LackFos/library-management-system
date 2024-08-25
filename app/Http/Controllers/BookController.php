<?php

namespace App\Http\Controllers;

use App\Enums\BorrowStatus;
use App\Models\Book;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function all(Request $request)
    {
        try {
            $keyword = $request->query('search');
    
            $query = Book::query();
    
            if ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            }

            $books = $query->withCount([
                'borrowed' => function ($query) {
                    $query->where('borrow_status_id', BorrowStatus::BORROWING);
                }
            ])->get();
    
            $books->each(function ($book) {
                $book->available_stock = $book->stock - $book->borrowed_count;
            });
    
            $message = $books->isEmpty() ? 'Book not found' : 'Book found';
    
            return ResponseHelper::returnOkResponse($message, $books);
        } catch (\Exception $ex) {
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function create(CreateBookRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $book = Book::create($validated);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $filePath = Storage::disk('public')->putFile('/images', $image);
                $fileUrl = Storage::url($filePath);
                $book->image = $fileUrl;
                $book->save();
            }

            if($request->expectsJson()) {
                DB::commit();
                return ResponseHelper::returnOkResponse('Book created', $book);
            } else {
                return redirect('/buku/' . $book->id)->with('success', 'Buku berhasil ditambahkan');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
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

            $previousImage = $book->image; 

            if($request->hasFile('image')) {
                if($previousImage !== '/storage/images/noimage.jpg') {
                    Storage::disk('public')->delete(preg_replace('/^\/storage/', '', $previousImage));
                }

                $image = $request->file('image');
                $filePath = Storage::disk('public')->putFile('/images', $image);
                $fileUrl = Storage::url($filePath);
                $book->image = $fileUrl;
                $book->save();
            }

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

            $previousImage = $book->image;

            if($previousImage !== '/storage/images/noimage.jpg') {
                Storage::disk('public')->delete(preg_replace('/^\/storage/', '', $previousImage));
            }

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
