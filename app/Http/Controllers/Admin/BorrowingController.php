<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->paginate(10);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function markAsReturned(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Book is already returned.');
        }

        $fineRatePerDay = 10;
        $today = Carbon::today();
        $dueDate = Carbon::parse($borrowing->due_date);

        if ($today->gt($dueDate)) {
            $daysOverdue = $dueDate->diffInDays($today);
            $amount = $daysOverdue * $fineRatePerDay;

            $fine = Fine::firstOrNew(['borrowing_id' => $borrowing->id]);

            if ($fine->status !== 'paid') {
                $fine->user_id = $borrowing->user_id;
                $fine->amount = $amount;
                $fine->save();
            }
        }

        $borrowing->update([
            'status' => 'returned',
            'return_date' => $today,
        ]);

        if ($borrowing->book) {
            $borrowing->book->increment('available_copies');
        }

        return back()->with('success', 'Book marked as returned successfully.');
    }
}
