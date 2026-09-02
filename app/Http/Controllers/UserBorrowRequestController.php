<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRequest;
use App\Services\BookRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBorrowRequestController extends Controller
{
    public function __construct(private BookRecommendationService $recommendationService) {}

    public function store(Book $book)
    {
        $user = Auth::user();

        // Check if book has available copies
        if ($book->available_copies <= 0) {
            return back()->with('error', 'This book is currently unavailable.');
        }

        // Check if user already has a pending request or active borrowing for this book
        $existingRequest = BorrowRequest::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending or approved request for this book.');
        }

        // Create the borrow request
        BorrowRequest::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        $this->recommendationService->invalidateForUser($user);

        return back()->with('success', 'Your request to borrow this book has been submitted successfully.');
    }
}
