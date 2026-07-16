<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $books = Book::with(['category', 'author', 'publisher'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhereHas('author', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        return view('admin.books.create', compact('categories', 'authors', 'publishers'));
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book): View
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories', 'authors', 'publishers'));
    }

    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}
