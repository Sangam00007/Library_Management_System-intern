<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $query = Fine::with(['user', 'borrowing.book'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $fines = $query->paginate(10)->withQueryString();

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
