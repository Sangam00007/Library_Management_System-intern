<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFineController extends Controller
{
    public function index()
    {
        $fines = \App\Models\Fine::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->with('borrowing.book')
            ->latest()
            ->get();

        return view('user.fines.index', compact('fines'));
    }
}
