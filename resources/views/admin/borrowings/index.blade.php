@extends('admin.layouts.app')

@section('title', 'Manage Borrowings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Borrowings</h1>
            <p class="text-sm text-slate-500 mt-1">Manage library book borrowings and returns.</p>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl p-4">
        <form method="GET" action="{{ route('admin.borrowings.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-9 pr-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-colors" placeholder="Search by user or book...">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-sm font-medium text-slate-700 rounded-lg transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.borrowings.index') }}" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-sm font-medium text-slate-600 rounded-lg transition-colors">Clear</a>
            @endif
        </form>
    </div>

    <!-- Borrowings Table -->
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl overflow-hidden">
        @if($borrowings->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-sm font-medium text-slate-500">No borrowings found</h3>
                <p class="text-xs text-slate-500 mt-1">There are currently no active or past borrowings in the system.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">User</th>
                            <th scope="col" class="px-6 py-4 font-medium">Book</th>
                            <th scope="col" class="px-6 py-4 font-medium">Borrow Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Due Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-600">
                        @foreach($borrowings as $borrowing)
                        <tr class="even:bg-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $borrowing->user?->name }}</div>
                                <div class="text-xs text-slate-500">{{ $borrowing->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900 font-medium">{{ $borrowing->book?->title ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $borrowing->borrow_date?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $borrowing->status !== 'returned' && \Carbon\Carbon::parse($borrowing->due_date)->isPast() ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('M d, Y') ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($borrowing->status === 'returned')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Returned
                                    </span>
                                @elseif($borrowing->status === 'overdue' || \Carbon\Carbon::parse($borrowing->due_date)->isPast())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-600 border border-red-500/20">
                                        Overdue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-600 border border-blue-500/20">
                                        Issued
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($borrowing->status !== 'returned')
                                    <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="inline" onsubmit="return confirm('Mark this book as returned?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-medium text-slate-900 rounded-lg shadow-lg shadow-indigo-500/30 transition-all flex items-center gap-1.5 ml-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                            Mark Returned
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($borrowings->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $borrowings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
