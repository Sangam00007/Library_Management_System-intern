<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowRequest;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Publisher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $activeBorrowings = Borrowing::where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->with('book')
            ->latest('borrow_date')
            ->get();

        $pendingRequests = BorrowRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('book')
            ->latest()
            ->get();

        $unpaidFines = Fine::where('user_id', $user->id)
            ->where('status', 'unpaid')
            ->with('borrowing.book')
            ->get();

        $totalBorrowed = Borrowing::where('user_id', $user->id)->count();
        $totalReturned = Borrowing::where('user_id', $user->id)->where('status', 'returned')->count();
        $totalFinesAmount = Fine::where('user_id', $user->id)->where('status', 'unpaid')->sum('amount');
        $totalBooks = Book::count();

        $recentActivity = Borrowing::where('user_id', $user->id)
            ->with('book')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $featuredBooks = Book::with('author')->inRandomOrder()->take(12)->get();
        $latestBooks = Book::with('author')->latest()->take(6)->get();

        $wizardData = [];
        if (! $user->wizard_completed) {
            $wizardData['categories'] = Category::orderBy('name')->get();
            $wizardData['authors'] = Author::orderBy('name')->get();
            $wizardData['publishers'] = Publisher::orderBy('name')->get();
        }

        return view('user.dashboard', compact(
            'activeBorrowings',
            'pendingRequests',
            'unpaidFines',
            'totalBorrowed',
            'totalReturned',
            'totalFinesAmount',
            'totalBooks',
            'recentActivity',
            'featuredBooks',
            'latestBooks',
            'wizardData'
        ));
    }
}
