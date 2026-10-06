@extends('user.layouts.app')
@section('title', 'My Fines - Library Management System')

@section('content')
<div class="space-y-10">

    <div class="relative bg-white dark:bg-surface-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden px-6 py-12 sm:p-16 animate-fade-up">
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-rose-400/10 dark:bg-rose-500/5 rounded-full blur-[80px]"></div>
        <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-amber-400/10 dark:bg-amber-500/5 rounded-full blur-[80px]"></div>

        <div class="relative z-10 max-w-3xl">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight font-display">
                My <span class="bg-gradient-to-r from-rose-500 to-amber-500 -webkit-background-clip-text text-transparent bg-clip-text">Fines</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg mt-4">Track and review any fines associated with overdue book returns.</p>
        </div>
    </div>

    @if($fines->count() > 0)
        <div class="bg-white dark:bg-surface-900 border border-slate-100 dark:border-white/5 rounded-3xl overflow-hidden shadow-sm overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/50 dark:bg-white/[0.02] text-slate-500 dark:text-slate-400 font-semibold border-b border-slate-100 dark:border-white/5">
                    <tr>
                        <th class="px-6 py-4">Book</th>
                        <th class="px-6 py-4 hidden sm:table-cell">Date Incurred</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @foreach($fines as $fine)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-14 bg-slate-100 dark:bg-white/5 rounded overflow-hidden flex-shrink-0 border border-slate-100 dark:border-white/5">
                                            @if($fine->borrowing->book->cover_image)
                                            <img src="{{ Storage::url($fine->borrowing->book->cover_image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('user.books.show', $fine->borrowing->book) }}" class="font-bold text-slate-800 dark:text-white hover:text-accent-600 dark:hover:text-accent-400 transition-colors">{{ $fine->borrowing->book->title }}</a>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $fine->borrowing->book->author->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                                {{ $fine->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">
                                Rs. {{ number_format($fine->amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($fine->status === 'unpaid')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200/50 dark:border-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse-ring"></span> Unpaid
                                    </span>
                                @elseif($fine->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Paid
                                    </span>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">On {{ \Carbon\Carbon::parse($fine->paid_at)->format('M d, Y') }}</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16 bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm">
            <div class="w-20 h-20 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center mx-auto mb-5 border border-emerald-100 dark:border-emerald-500/20">
                <svg class="w-10 h-10 text-emerald-500 dark:text-emerald-400 animate-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-slate-800 dark:text-white font-bold text-lg mb-1">All Clear!</p>
            <p class="text-slate-500 dark:text-slate-400">You don't have any fines on your account.</p>
        </div>
    @endif

</div>
@endsection
