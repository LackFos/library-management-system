<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\userIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Laravel Framework 11.16.0';
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/users')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
        Route::get('/borrows', [BorrowController::class, 'userBorrows'])->middleware('auth:sanctum');
    });

    Route::prefix('/books')->middleware('auth:sanctum')->group(function () {
       Route::get('/', [BookController::class, 'all']);
       Route::get('/{book:isbn}', [BookController::class, 'detail']);
       Route::post('/', [BookController::class, 'create']);
       Route::put('/{book}', [BookController::class, 'update']);
       Route::delete('/{book}', [BookController::class, 'delete'])->middleware(userIsAdmin::class);
   });

   Route::prefix('/borrows')->middleware(['auth:sanctum', userIsAdmin::class])->group(function () {
        Route::get('/', [BorrowController::class, 'myBorrows']); 
        Route::get('/{borrow}', [BorrowController::class, 'detail']);
        Route::post('/', [BorrowController::class, 'create']); 
        Route::post('/{borrow}/return', [BorrowController::class, 'returnBook']);
   });

   Route::prefix('/penalties')->middleware(['auth:sanctum', userIsAdmin::class])->group(function () {
        Route::get('/', [PenaltyController::class, 'all']); 
        Route::get('/{penalty}', [PenaltyController::class, 'detail']); 
    });
}); 