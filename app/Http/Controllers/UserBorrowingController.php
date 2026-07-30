<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBorrowingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get pending/rejected requests
        $requests = BorrowRequest::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->get();

        // Get active and past borrowings
        $borrowings = Borrowing::where('user_id', $user->id)
            ->with('book')
            ->latest('borrow_date')
            ->get();

        return view('user.borrowings.index', compact('requests', 'borrowings'));
    }
}
