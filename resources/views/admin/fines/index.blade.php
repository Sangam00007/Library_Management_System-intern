@extends('admin.layouts.app')

@section('title', 'Manage Fines')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Fines</h1>
            <p class="text-sm text-slate-500 mt-1">Manage fines for overdue books.</p>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl p-4">
        <form method="GET" action="{{ route('admin.fines.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-9 pr-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-colors" placeholder="Search by user name or email...">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-sm font-medium text-slate-700 rounded-lg transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.fines.index') }}" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-sm font-medium text-slate-600 rounded-lg transition-colors">Clear</a>
            @endif
        </form>
    </div>

    <!-- Fines Table -->
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl overflow-hidden">
        @if($fines->isEmpty())
            <div class="px-6 py-16 text-center">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 font-bold text-xl">Rs</div>
                <h3 class="text-sm font-medium text-slate-500">No fines found</h3>
                <p class="text-xs text-slate-500 mt-1">There are currently no fines recorded in the system.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">User</th>
                            <th scope="col" class="px-6 py-4 font-medium">Book</th>
                            <th scope="col" class="px-6 py-4 font-medium">Due Date</th>
                            <th scope="col" class="px-6 py-4 font-medium">Amount</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-600">
                        @foreach($fines as $fine)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $fine->user?->name }}</div>
                                <div class="text-xs text-slate-500">{{ $fine->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">{{ $fine->borrowing?->book?->title ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $fine->borrowing?->due_date?->format('M d, Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                Rs {{ number_format($fine->amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($fine->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-600 border border-red-500/20">
                                        Unpaid
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($fine->status === 'unpaid')
                                    <form method="POST" action="{{ route('admin.fines.pay', $fine) }}" class="inline" onsubmit="return confirm('Mark this fine as paid?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-500 text-xs font-medium text-slate-900 rounded-lg shadow-lg shadow-green-500/30 transition-all flex items-center gap-1.5 ml-auto">
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
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $fines->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
