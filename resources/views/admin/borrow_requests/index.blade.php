@extends('admin.layouts.app')
@section('title', 'Manage Borrow Requests - Library Management System')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Borrow Requests</h1>
            <p class="text-slate-500 text-sm mt-1">Review and manage book borrowing requests from users.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-4">
        <span class="text-sm font-medium text-slate-500">Filter Status:</span>
        <div class="flex gap-2">
            <a href="{{ route('admin.borrow_requests.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg {{ request('status', 'pending') === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">Pending</a>
            <a href="{{ route('admin.borrow_requests.index', ['status' => 'approved']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg {{ request('status') === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">Approved</a>
            <a href="{{ route('admin.borrow_requests.index', ['status' => 'rejected']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg {{ request('status') === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">Rejected</a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Request Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $request)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($request->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $request->user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $request->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 text-sm max-w-[200px] truncate" title="{{ $request->book->title }}">{{ $request->book->title }}</p>
                                <p class="text-xs {{ $request->book->available_copies > 0 ? 'text-emerald-500' : 'text-rose-500' }} font-medium mt-0.5">
                                    {{ $request->book->available_copies }} available
                                </p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $request->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($request->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Pending</span>
                                @elseif($request->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Approved</span>
                                @elseif($request->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($request->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.borrow_requests.approve', $request) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-500 hover:text-white transition-colors" title="Approve">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.borrow_requests.reject', $request) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 text-rose-600 bg-rose-50 rounded-lg hover:bg-rose-500 hover:text-white transition-colors" title="Reject">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-slate-800 font-medium text-lg">No requests found.</h3>
                                <p class="text-slate-500 text-sm mt-1">There are no {{ request('status', 'pending') }} borrow requests at the moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
