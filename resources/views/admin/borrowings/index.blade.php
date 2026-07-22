@extends('admin.layouts.app')

@section('title', 'Manage Borrowings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Borrowings</h1>
            <p class="text-sm text-gray-400 mt-1">Manage library book borrowings and returns.</p>
        </div>
        <form action="{{ route('admin.borrowings.index') }}" method="GET" class="flex gap-2">
            <!-- Space for future search filter -->
        </form>
    </div>

    <!-- Borrowings Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden">
        @if($borrowings->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-sm font-medium text-gray-400">No borrowings found</h3>
                <p class="text-xs text-gray-500 mt-1">There are currently no active or past borrowings in the system.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-900/50 text-gray-400 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">User</th>
                            <th scope="col" class="px-6 py-4 font-medium">Book</th>
                            <th scope="col" class="px-6 py-4 font-medium">Borrow Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Due Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 text-gray-300">
                        @foreach($borrowings as $borrowing)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $borrowing->user?->name }}</div>
                                <div class="text-xs text-gray-500">{{ $borrowing->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">{{ $borrowing->book?->title ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $borrowing->borrow_date?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $borrowing->status !== 'returned' && \Carbon\Carbon::parse($borrowing->due_date)->isPast() ? 'text-red-400 font-semibold' : 'text-gray-400' }}">
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('M d, Y') ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($borrowing->status === 'returned')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Returned
                                    </span>
                                @elseif($borrowing->status === 'overdue' || \Carbon\Carbon::parse($borrowing->due_date)->isPast())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                        Overdue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        Issued
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($borrowing->status !== 'returned')
                                    <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="inline" onsubmit="return confirm('Mark this book as returned?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-medium text-white rounded-lg shadow-lg shadow-indigo-500/30 transition-all flex items-center gap-1.5 ml-auto">
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
                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $borrowings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
