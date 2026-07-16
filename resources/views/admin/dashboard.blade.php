@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-gray-400 mt-1">Welcome back, {{ auth('admin')->user()->name ?? 'Administrator' }}. Here's what's happening today.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-gray-800 border border-gray-700 hover:bg-gray-700 text-sm font-medium text-white rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Report
            </button>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-sm font-medium text-white rounded-lg shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Book
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Books -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-blue-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
            </div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Books</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($totalBooks) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                @if($bookChange >= 0)
                    <span class="text-green-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $bookChange }}%
                    </span>
                @else
                    <span class="text-red-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                        {{ abs($bookChange) }}%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">vs last month</span>
            </div>
        </div>

        <!-- Active Members -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            </div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Active Members</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($totalMembers) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                @if($memberChange >= 0)
                    <span class="text-green-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $memberChange }}%
                    </span>
                @else
                    <span class="text-red-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                        {{ abs($memberChange) }}%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">vs last month</span>
            </div>
        </div>

        <!-- Books Borrowed -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-amber-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Books Borrowed</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($activeBorrowings) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                @if($borrowingChange >= 0)
                    <span class="text-green-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $borrowingChange }}%
                    </span>
                @else
                    <span class="text-red-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                        {{ abs($borrowingChange) }}%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">vs last month</span>
            </div>
        </div>

        <!-- Fines Collected -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Fines Collected</p>
                    <h3 class="text-2xl font-bold text-white mt-1">${{ number_format($totalFinesCollected, 2) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm relative z-10">
                @if($fineChange >= 0)
                    <span class="text-green-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $fineChange }}%
                    </span>
                @else
                    <span class="text-red-400 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                        {{ abs($fineChange) }}%
                    </span>
                @endif
                <span class="text-gray-500 ml-2">vs last month</span>
            </div>
        </div>
    </div>

    <!-- Overdue Alert -->
    @if($overdueCount > 0)
    <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-red-300">Overdue Alert</h3>
            <p class="text-sm text-red-400/80 mt-0.5">{{ $overdueCount }} {{ Str::plural('book', $overdueCount) }} currently overdue. Please follow up with the members.</p>
        </div>
    </div>
    @endif

    <!-- Recent Borrowings Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-700/50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white">Recent Borrowings</h2>
            <a href="#" class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors">View all</a>
        </div>

        @if($recentBorrowings->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <h3 class="text-sm font-medium text-gray-400">No borrowings yet</h3>
                <p class="text-xs text-gray-500 mt-1">Borrowing records will appear here once members start borrowing books.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-900/50 text-gray-400 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Book Title</th>
                            <th scope="col" class="px-6 py-4 font-medium">Member</th>
                            <th scope="col" class="px-6 py-4 font-medium">Borrow Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Due Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 text-gray-300">
                        @foreach($recentBorrowings as $borrowing)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-10 bg-gray-700 rounded shadow flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">{{ $borrowing->book?->title ?? 'Deleted Book' }}</p>
                                        @if($borrowing->book?->isbn)
                                            <p class="text-xs text-gray-500">ISBN: {{ $borrowing->book->isbn }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @php
                                        $initials = collect(explode(' ', $borrowing->user?->name ?? 'NA'))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                                        $colors = ['blue', 'purple', 'amber', 'emerald', 'pink', 'cyan'];
                                        $color = $colors[$borrowing->id % count($colors)];
                                    @endphp
                                    <div class="w-6 h-6 rounded-full bg-{{ $color }}-500/20 text-{{ $color }}-400 flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
                                    <span>{{ $borrowing->user?->name ?? 'Deleted User' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $borrowing->borrow_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 {{ $borrowing->status === 'issued' && $borrowing->due_date->isPast() ? 'text-red-400 font-medium' : '' }}">
                                {{ $borrowing->due_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($borrowing->status === 'returned')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        Returned
                                    </span>
                                @elseif($borrowing->status === 'overdue' || ($borrowing->status === 'issued' && $borrowing->due_date->isPast()))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                        Overdue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Borrowed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
