<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\OneTimePasswordController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\Verified;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Laravel Framework 11.16.0';
});

Route::prefix('/v1')->group(function () {
    Route::middleware(['auth:sanctum', UserIsAdmin::class])->get('/stats', function() {
        $stats = [
            'book_count' => Book::count(),
            'borrow_count' => Borrow::where('borrow_status_id', '1')->count(),
            'overdue_count' => Borrow::where('borrow_status_id', '1')->get()->filter(function ($borrow) {
                return $borrow->getPenaltyFee() !== null;
            })->count(),
        ];

        return ResponseHelper::returnOkResponse("System stats", $stats);
    });

    Route::prefix('/users')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);

        Route::post('/reset-password', [UserController::class, 'resetPassword']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/verify', [UserController::class, 'verifyAccount']);
            Route::post('/send-verify-otp', [UserController::class, 'sendVerifyOtp']);
            Route::get('/borrows', [BorrowController::class, 'myBorrows'])->middleware([Verified::class]);

            Route::get('/stats', function () {
                /** @var User $user */
                $user = Auth::user();

                $penaltyFeeAmount = 0;

                $stats = [
                    'borrow_count' => $user->borrows->where('borrow_status_id', '1')->count(),
                    'overdue_count' => $user->borrows()->where('borrow_status_id', '1')->get()->filter(function ($borrow) use (&$penaltyFeeAmount) {
                        $penaltyFee = $borrow->getPenaltyFee();
                        
                        // $penaltyFeeAmount += $penaltyFee;
                        $penaltyFeeAmount += 100;
                        
                        return $penaltyFee !== null;
                    })->count(),
                    'penalty_fee' => $penaltyFeeAmount,
                ];

                return ResponseHelper::returnOkResponse("User stats", $stats);
            });
        });
    });

    Route::prefix('/books')->middleware(['auth:sanctum', Verified::class])->group(function () {
       Route::get('/', [BookController::class, 'all']);
       Route::get('/{book:isbn}', [BookController::class, 'detail']);
       Route::post('/', [BookController::class, 'create'])->middleware(UserIsAdmin::class);
       Route::put('/{book}', [BookController::class, 'update'])->middleware(UserIsAdmin::class);
       Route::delete('/{book}', [BookController::class, 'delete'])->middleware(UserIsAdmin::class);
   });

   Route::prefix('/borrows')->middleware(['auth:sanctum', UserIsAdmin::class])->group(function () {
        Route::get('/', [BorrowController::class, 'all']); 
        Route::get('/{borrow}', [BorrowController::class, 'detail']);
        Route::post('/', [BorrowController::class, 'create']); 
        Route::post('/{borrow}/return', [BorrowController::class, 'returnBook']);
   });

   Route::prefix('/penalties')->middleware(['auth:sanctum', UserIsAdmin::class])->group(function () {
        Route::get('/', [PenaltyController::class, 'all'])->middleware(UserIsAdmin::class); 
        Route::get('/{penalty}', [PenaltyController::class, 'detail'])->middleware(UserIsAdmin::class); 
    });

    Route::prefix('otps')->group(function () {
        Route::post('/verify', [OneTimePasswordController::class, 'verify']);
    });
}); 