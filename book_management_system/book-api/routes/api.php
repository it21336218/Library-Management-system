<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


// Protected routes - Require authentication (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);          // Get all books
    Route::get('/books/{id}', [BookController::class, 'show']);      // Get a specific book by ID
    Route::post('/books', [BookController::class, 'store']);         // Add a new book
    Route::put('/books/{id}', [BookController::class, 'update']);    // Update a book by ID
    Route::delete('/books/{id}', [BookController::class, 'destroy']); // Delete a book by ID
});
