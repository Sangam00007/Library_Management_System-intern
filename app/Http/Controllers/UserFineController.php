<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Support\Facades\Auth;

class UserFineController extends Controller
{
    public function index()
    {
        $fines = Fine::where('user_id', Auth::id())
            ->with('borrowing.book')
            ->latest()
            ->get();

        return view('user.fines.index', compact('fines'));
    }
}
