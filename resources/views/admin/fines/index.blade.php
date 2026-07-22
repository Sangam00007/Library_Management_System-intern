@extends('admin.layouts.app')

@section('title', 'Manage Fines')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Fines</h1>
            <p class="text-sm text-gray-400 mt-1">Manage fines for overdue books.</p>
        </div>
        <form action="{{ route('admin.fines.index') }}" method="GET" class="flex gap-2">
            <!-- Currently no search filter, but structure is here for future expansion -->
        </form>
    </div>

    <!-- Fines Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden">
        @if($fines->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-sm font-medium text-gray-400">No fines found</h3>
                <p class="text-xs text-gray-500 mt-1">There are currently no fines recorded in the system.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-900/50 text-gray-400 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">User</th>
                            <th scope="col" class="px-6 py-4 font-medium">Book</th>
                            <th scope="col" class="px-6 py-4 font-medium">Due Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Amount</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 text-gray-300">
                        @foreach($fines as $fine)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $fine->user?->name }}</div>
                                <div class="text-xs text-gray-500">{{ $fine->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white">{{ $fine->borrowing?->book?->title ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $fine->borrowing?->due_date?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-white">
                                Rs {{ number_format($fine->amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($fine->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                        Unpaid
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($fine->status === 'unpaid')
                                    <form method="POST" action="{{ route('admin.fines.pay', $fine) }}" class="inline" onsubmit="return confirm('Mark this fine as paid?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-500 text-xs font-medium text-white rounded-lg shadow-lg shadow-green-500/30 transition-all flex items-center gap-1.5 ml-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Mark Paid
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
            @if($fines->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $fines->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
