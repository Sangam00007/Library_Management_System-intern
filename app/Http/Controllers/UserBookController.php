<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\BookRecommendationService;
use Illuminate\Http\Request;

class UserBookController extends Controller
{
    public function __construct(private BookRecommendationService $recommendationService) {}

    public function index(Request $request)
    {
        $query = Book::with(['author', 'category']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('author', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('user.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['author', 'category', 'publisher']);

        $similarBooks = $this->recommendationService->getRecommendationsForBook($book, 6);

        return view('user.books.show', compact('book', 'similarBooks'));
    }
}
