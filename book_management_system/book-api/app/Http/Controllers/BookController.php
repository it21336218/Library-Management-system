<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // GET /api/books
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // GET /api/books/{id}
    public function show($id)
    {
        $book = Book::find($id);
        if ($book) {
            return response()->json($book, 200);
        }
        return response()->json(['error' => 'Book not found'], 404);
    }

    // POST /api/books
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
            'isbn' => 'required|string|max:13',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    // PUT /api/books/{id}
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
            'isbn' => 'required|string|max:13',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book->update($request->all());
        return response()->json($book, 200);
    }

    // DELETE /api/books/{id}
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(null, 204);
    }
}
