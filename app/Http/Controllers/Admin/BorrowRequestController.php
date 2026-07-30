<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = BorrowRequest::with(['user', 'book'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
             $query->where('status', 'pending');
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('admin.borrow_requests.index', compact('requests'));
    }

    public function approve(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        if ($borrowRequest->book->available_copies <= 0) {
            return back()->with('error', 'Book is currently out of stock.');
        }

        // Update request status
        $borrowRequest->update(['status' => 'approved']);

        // Create borrowing record
        Borrowing::create([
            'user_id' => $borrowRequest->user_id,
            'book_id' => $borrowRequest->book_id,
            'borrow_date' => Carbon::today(),
            'due_date' => Carbon::today()->addDays(14), // Standard 14-day borrow period
            'status' => 'issued',
        ]);

        // Decrement available copies
        $borrowRequest->book->decrement('available_copies');

        return back()->with('success', 'Request approved and book issued to user.');
    }

    public function reject(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $borrowRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Request rejected.');
    }
}
