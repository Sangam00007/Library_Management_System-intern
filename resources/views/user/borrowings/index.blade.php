@extends('user.layouts.app')
@section('title', 'My Borrowings - Library Management System')

@section('content')
<div class="space-y-10">

    <div class="relative bg-white dark:bg-surface-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden px-6 py-12 sm:p-16 animate-fade-up">
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-accent-400/10 dark:bg-accent-500/5 rounded-full blur-[80px]"></div>
        <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-blue-400/10 dark:bg-blue-500/5 rounded-full blur-[80px]"></div>

        <div class="relative z-10 max-w-3xl">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight font-display">
                My <span class="text-gradient">Borrowings</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg mt-4">Track your active borrowings, past reading history, and pending requests.</p>
        </div>
    </div>

    <div x-data="{ tab: 'active' }">
        <!-- Tabs -->
        <div class="flex gap-4 border-b border-slate-200 dark:border-white/10 mb-8 overflow-x-auto pb-px custom-scrollbar">
            <button @click="tab = 'active'" :class="{'text-accent-600 dark:text-accent-400 border-b-2 border-accent-500 font-semibold': tab === 'active', 'text-slate-500 dark:text-slate-400 font-medium hover:text-slate-700 dark:hover:text-slate-300': tab !== 'active'}" class="px-4 py-3 text-sm transition-colors whitespace-nowrap">
                Active Borrowings
            </button>
            <button @click="tab = 'requests'" :class="{'text-accent-600 dark:text-accent-400 border-b-2 border-accent-500 font-semibold': tab === 'requests', 'text-slate-500 dark:text-slate-400 font-medium hover:text-slate-700 dark:hover:text-slate-300': tab !== 'requests'}" class="px-4 py-3 text-sm transition-colors whitespace-nowrap flex items-center gap-2">
                Pending Requests
                @if($requests->where('status', 'pending')->count() > 0)
                    <span class="bg-accent-100 dark:bg-accent-500/20 text-accent-700 dark:text-accent-400 py-0.5 px-2 rounded-full text-xs font-bold">{{ $requests->where('status', 'pending')->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'history'" :class="{'text-accent-600 dark:text-accent-400 border-b-2 border-accent-500 font-semibold': tab === 'history', 'text-slate-500 dark:text-slate-400 font-medium hover:text-slate-700 dark:hover:text-slate-300': tab !== 'history'}" class="px-4 py-3 text-sm transition-colors whitespace-nowrap">
                Reading History
            </button>
        </div>

        <!-- Active Borrowings Tab -->
        <div x-show="tab === 'active'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @php $activeBorrowings = $borrowings->where('status', 'issued'); @endphp
            @if($activeBorrowings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeBorrowings as $borrowing)
                        <div class="bg-white dark:bg-surface-900 rounded-2xl p-5 border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md hover:border-accent-200 dark:hover:border-accent-500/20 transition-all flex gap-4 card-lift">
                            <div class="w-24 h-36 bg-slate-100 dark:bg-white/5 rounded-xl overflow-hidden shadow-inner dark:shadow-none flex-shrink-0 border border-slate-100 dark:border-white/5">
                                @if($borrowing->book->cover_image)
                                    <img src="{{ Storage::url($borrowing->book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600 bg-slate-50 dark:bg-white/[0.02]">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col min-w-0">
                                <a href="{{ route('user.books.show', $borrowing->book) }}" class="font-bold text-slate-800 dark:text-white line-clamp-2 hover:text-accent-600 dark:hover:text-accent-400 transition-colors">{{ $borrowing->book->title }}</a>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $borrowing->book->author->name }}</p>
                                <div class="mt-auto">
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Borrowed: {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('M d, Y') }}</p>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                        $isOverdue = $dueDate->isPast();
                                    @endphp
                                    <div class="mt-2 inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-semibold {{ $isOverdue ? 'bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-100 dark:border-rose-500/20' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20' }}">
                                        @if($isOverdue)
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Overdue (Due: {{ $dueDate->format('M d') }})
                                        @else
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Due: {{ $dueDate->format('M d, Y') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm">
                    <div class="w-20 h-20 rounded-full bg-slate-50 dark:bg-white/5 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <p class="text-slate-800 dark:text-white font-bold text-lg mb-1">No Active Borrowings</p>
                    <p class="text-slate-500 dark:text-slate-400">You don't have any books checked out right now.</p>
                    <a href="{{ route('user.books.index') }}" class="inline-block mt-6 px-6 py-2.5 bg-slate-900 dark:bg-accent-600 text-white font-semibold rounded-xl hover:bg-slate-800 dark:hover:bg-accent-700 transition-colors shadow-lg shadow-slate-900/20 dark:shadow-accent-600/20 btn-ripple">Explore Books &rarr;</a>
                </div>
            @endif
        </div>

        <!-- Requests Tab -->
        <div x-show="tab === 'requests'" style="display: none;" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @php $pendingRequests = $requests->whereIn('status', ['pending', 'rejected']); @endphp
            @if($pendingRequests->count() > 0)
                <div class="bg-white dark:bg-surface-900 border border-slate-100 dark:border-white/5 rounded-3xl overflow-hidden shadow-sm overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/50 dark:bg-white/[0.02] text-slate-500 dark:text-slate-400 font-semibold border-b border-slate-100 dark:border-white/5">
                            <tr>
                                <th class="px-6 py-4">Book</th>
                                <th class="px-6 py-4 hidden sm:table-cell">Request Date</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($pendingRequests as $request)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-14 bg-slate-100 dark:bg-white/5 rounded overflow-hidden flex-shrink-0 border border-slate-100 dark:border-white/5">
                                                 @if($request->book->cover_image)
                                                    <img src="{{ Storage::url($request->book->cover_image) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('user.books.show', $request->book) }}" class="font-bold text-slate-800 dark:text-white hover:text-accent-600 dark:hover:text-accent-400 transition-colors">{{ $request->book->title }}</a>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $request->book->author->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                        {{ $request->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($request->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse-ring"></span> Pending
                                            </span>
                                        @elseif($request->status === 'rejected')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200/50 dark:border-rose-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                 <div class="text-center py-16 bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm">
                    <div class="w-20 h-20 rounded-full bg-slate-50 dark:bg-white/5 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <p class="text-slate-800 dark:text-white font-bold text-lg mb-1">No Pending Requests</p>
                    <p class="text-slate-500 dark:text-slate-400">You don't have any pending book requests.</p>
                </div>
            @endif
        </div>

        <!-- History Tab -->
        <div x-show="tab === 'history'" style="display: none;" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
             @php $pastBorrowings = $borrowings->where('status', 'returned'); @endphp
             @if($pastBorrowings->count() > 0)
                <div class="bg-white dark:bg-surface-900 border border-slate-100 dark:border-white/5 rounded-3xl overflow-hidden shadow-sm overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/50 dark:bg-white/[0.02] text-slate-500 dark:text-slate-400 font-semibold border-b border-slate-100 dark:border-white/5">
                            <tr>
                                <th class="px-6 py-4">Book</th>
                                <th class="px-6 py-4 hidden sm:table-cell">Borrowed</th>
                                <th class="px-6 py-4 hidden sm:table-cell">Returned</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($pastBorrowings as $borrowing)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-14 bg-slate-100 dark:bg-white/5 rounded overflow-hidden flex-shrink-0 border border-slate-100 dark:border-white/5">
                                                 @if($borrowing->book->cover_image)
                                                    <img src="{{ Storage::url($borrowing->book->cover_image) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('user.books.show', $borrowing->book) }}" class="font-bold text-slate-800 dark:text-white hover:text-accent-600 dark:hover:text-accent-400 transition-colors">{{ $borrowing->book->title }}</a>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $borrowing->book->author->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                        {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                        {{ \Carbon\Carbon::parse($borrowing->return_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-slate-300">
                                            Returned
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                 <div class="text-center py-16 bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm">
                    <div class="w-20 h-20 rounded-full bg-slate-50 dark:bg-white/5 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-800 dark:text-white font-bold text-lg mb-1">No Reading History</p>
                    <p class="text-slate-500 dark:text-slate-400">You haven't returned any books yet.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
