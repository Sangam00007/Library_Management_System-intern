<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with(['user', 'borrowing.book'])
            ->latest()
            ->paginate(10);

        return view('admin.fines.index', compact('fines'));
    }

    public function markAsPaid(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->with('error', 'Fine is already paid.');
        }

        $fine->update(['status' => 'paid']);

        return back()->with('success', 'Fine marked as paid successfully.');
    }
}
