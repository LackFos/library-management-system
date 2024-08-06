<?php

namespace App\Http\Controllers;

use App\Enums\BorrowStatus;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Borrow\CreateBorrowRequest;
use App\Http\Requests\Borrow\UpdateBorrowRequest;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function all(Request $request)
    {
        try {
            $query = Borrow::latest();

            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');

            if ($startDate && $endDate) {
                $dateRange = [$startDate, $endDate];
                $query->whereBetween('created_at', $dateRange);
            } else if ($startDate) {
                $query->where('created_at', $startDate);
            }

            $borrows = $query->get();

            $message = $borrows->isNotEmpty() ? 'Borrow found' : 'Borrow not found';
            
            return ResponseHelper::returnOkResponse($message, $borrows);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }

    public function myBorrows() {
        try {
            /** @var User $user */
            $user = auth()->user();

            $borrows = $user->borrows()->get();
            
            return ResponseHelper::returnOkResponse('Borrow found', $borrows);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }

    public function detail(Borrow $borrow)
    {
        try {
            $penaltyFee = $borrow->getPenaltyFee();

            if ($penaltyFee) {
                $borrow['penalty_fee'] = $penaltyFee;
            }

            $borrow->load('books', 'borrowStatus');

            return ResponseHelper::returnOkResponse('Borrow found', $borrow);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }



    public function create(CreateBorrowRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['borrow_status_id'] = BorrowStatus::BORROWING;

            /** @var User $user */
            $user = auth()->user();

            $books = Book::find($validated['book_id']);

            foreach ($books as $book) {
                $currentBorrowedCount = $book->borrowed()->where('borrow_status_id', BorrowStatus::BORROWING)->count();

                $isOutOfStock = $currentBorrowedCount >= $book->stock;
                
                if ($isOutOfStock) {
                    if($request->expectsJson()) {
                        return ResponseHelper::throwConflictError("The book with ID '" . $book->id . "' is currently unavailable.");
                    } else {
                        return redirect()->back()->with('error', 'Buku ini tidak tersedia saat ini');
                    }
                }
            }

            $borrow = $user->borrows()->create($validated);
            $borrow->books()->sync($validated['book_id']);

            if($request->expectsJson()) {
                return ResponseHelper::returnOkResponse('Book borrowed successfully', $borrow);
            } else {
                return redirect()->back()->with('success', 'Buku berhasil dipinjam');
            }
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }

    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        try {
            $validated = $request->validated();

            $borrow->update($validated);

            return ResponseHelper::returnOkResponse('Borrow updated successfully', $borrow);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }

    public function returnBook(Borrow $borrow)
    {
        try {
            $penaltyFee = $borrow->getPenaltyFee();

            if ($penaltyFee) {
                $borrow->penalty()->create(['amount' => $penaltyFee]);
            }

            $borrow->borrow_status_id = BorrowStatus::RETURNED;
            $borrow->save();

            return ResponseHelper::returnOkResponse('Borrow returned successfully', $borrow);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }
}
