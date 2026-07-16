<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Total stats
        $totalBooks = Book::count();
        $totalMembers = User::count();
        $activeBorrowings = Borrowing::where('status', 'issued')->count();
        $totalFinesCollected = Fine::where('status', 'paid')->sum('amount');

        // Previous month stats for comparison
        $lastMonthBooks = Book::where('created_at', '<=', $lastMonthEnd)->count();
        $lastMonthMembers = User::where('created_at', '<=', $lastMonthEnd)->count();
        $lastMonthBorrowings = Borrowing::where('status', 'issued')
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
        $lastMonthFines = Fine::where('status', 'paid')
            ->where('created_at', '<=', $lastMonthEnd)
            ->sum('amount');

        // Calculate percentage changes
        $bookChange = $lastMonthBooks > 0
            ? round((($totalBooks - $lastMonthBooks) / $lastMonthBooks) * 100, 1)
            : ($totalBooks > 0 ? 100 : 0);

        $memberChange = $lastMonthMembers > 0
            ? round((($totalMembers - $lastMonthMembers) / $lastMonthMembers) * 100, 1)
            : ($totalMembers > 0 ? 100 : 0);

        $borrowingChange = $lastMonthBorrowings > 0
            ? round((($activeBorrowings - $lastMonthBorrowings) / $lastMonthBorrowings) * 100, 1)
            : ($activeBorrowings > 0 ? 100 : 0);

        $fineChange = $lastMonthFines > 0
            ? round((($totalFinesCollected - $lastMonthFines) / $lastMonthFines) * 100, 1)
            : ($totalFinesCollected > 0 ? 100 : 0);

        // Recent borrowings with eager loading to prevent N+1
        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest('borrow_date')
            ->limit(10)
            ->get();

        // Overdue count
        $overdueCount = Borrowing::where('status', 'issued')
            ->where('due_date', '<', $now)
            ->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'activeBorrowings',
            'totalFinesCollected',
            'bookChange',
            'memberChange',
            'borrowingChange',
            'fineChange',
            'recentBorrowings',
            'overdueCount',
        ));
    }
}
