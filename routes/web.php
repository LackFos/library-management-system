<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Requests\Book\CreateBookRequest;
use Illuminate\Support\Facades\Route;



Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login']);

    Route::get('/', function () {
        return view('pages.dashboard');
    });
    
    Route::get('/buku', [PageController::class, 'bookList']);
    Route::post('/buku', [BookController::class, 'create']);
    Route::put('/buku/{book}', [BookController::class, 'update']);
    Route::delete('/buku/{book}', [BookController::class, 'delete']);
    
    Route::get('/pinjam', [PageController::class, 'cart']);
    Route::post('/pinjam', [BorrowController::class, 'create']); 

Route::get('/buku/tambah', function () {
    return view('pages.book-create');
});

Route::post('/test', function(CreateBookRequest $request) {
    $validated = $request->validated();
});

Route::get('/buku/{book}', [PageController::class, 'bookDetail']);

Route::get('/pengembalian', function () {
    return view('pages.borrow-list');
});
