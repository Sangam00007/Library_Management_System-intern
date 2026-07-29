@extends('user.layouts.app')
@section('title', 'My Dashboard - Library Management System')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Section -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Welcome back, <span class="text-gradient">{{ explode(' ', Auth::user()->name)[0] }}</span> 👋
            </h1>
            <p class="mt-2 text-slate-500 font-medium text-sm sm:text-base">Track your reading progress and discover new books.</p>
        </div>
        <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-800 shadow-lg shadow-slate-900/20 transition-all hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Find a Book
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Stat Card 1 -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-blue-500 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4 shadow-sm border border-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Borrowing</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-extrabold text-slate-800">{{ $activeBorrowings->count() }}</p>
                    <p class="text-sm text-slate-400 font-medium">books</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-emerald-500 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4 shadow-sm border border-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Books Read</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-extrabold text-slate-800">{{ $totalReturned }}</p>
                    <p class="text-sm text-slate-400 font-medium">total</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-amber-500 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4 shadow-sm border border-amber-50">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Pending</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-extrabold text-slate-800">{{ $pendingRequests->count() }}</p>
                    <p class="text-sm text-slate-400 font-medium">requests</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1 {{ $totalFinesAmount > 0 ? 'bg-rose-50/50 border-rose-100' : '' }}">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-rose-500 transform translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl {{ $totalFinesAmount > 0 ? 'bg-rose-100 text-rose-600 border border-rose-50 shadow-sm' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Fines</p>
                <div class="flex items-baseline gap-1 mt-1">
                    <p class="text-xl font-bold text-slate-400">Rs.</p>
                    <p class="text-3xl font-extrabold {{ $totalFinesAmount > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ number_format($totalFinesAmount, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Left Column (Wider) -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- Currently Reading -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        Currently Reading
                    </h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">View all</a>
                </div>
                <div class="p-6">
                    @if($activeBorrowings->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @foreach($activeBorrowings as $borrowing)
                                <div class="flex gap-4 p-4 rounded-2xl border border-slate-100 hover:border-emerald-100 hover:bg-emerald-50/30 transition-all group shadow-sm">
                                    <!-- Cover -->
                                    <div class="w-20 h-28 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 shadow-sm">
                                        @if($borrowing->book->cover_image)
                                            <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Details -->
                                    <div class="flex-1 min-w-0 flex flex-col justify-between py-1">
                                        <div>
                                            <h4 class="text-base font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-emerald-700 transition-colors">{{ $borrowing->book->title }}</h4>
                                            <p class="text-xs text-slate-500 mt-1">Borrowed: {{ $borrowing->borrow_date->format('M d, Y') }}</p>
                                        </div>
                                        
                                        @php
                                            $daysLeft = now()->diffInDays($borrowing->due_date, false);
                                            $totalDays = $borrowing->borrow_date->diffInDays($borrowing->due_date);
                                            $daysPassed = $totalDays - max(0, $daysLeft);
                                            $progress = $totalDays > 0 ? min(100, ($daysPassed / $totalDays) * 100) : 100;
                                            
                                            $statusColor = $daysLeft < 0 ? 'bg-rose-500' : ($daysLeft <= 3 ? 'bg-amber-500' : 'bg-emerald-500');
                                            $bgLight = $daysLeft < 0 ? 'bg-rose-100' : 'bg-slate-100';
                                        @endphp
                                        
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $daysLeft < 0 ? 'text-rose-600' : 'text-slate-500' }}">
                                                    @if($daysLeft < 0) Overdue @elseif($daysLeft == 0) Due today @else {{ intval($daysLeft) }} days left @endif
                                                </span>
                                                <span class="text-[10px] text-slate-400">{{ $borrowing->due_date->format('M d') }}</span>
                                            </div>
                                            <div class="w-full h-1.5 {{ $bgLight }} rounded-full overflow-hidden">
                                                <div class="h-full {{ $statusColor }} rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4 border-2 border-dashed border-slate-100 rounded-2xl">
                            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h4 class="text-base font-semibold text-slate-700">No active borrowings</h4>
                            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Your reading list is currently empty. Explore the catalog to find your next great read.</p>
                            <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-2 mt-5 px-5 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                                Browse Catalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity List -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 px-2">Recent Activity</h3>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    @if($recentActivity->count() > 0)
                        <div class="space-y-6">
                            @foreach($recentActivity as $activity)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $activity->status == 'borrowed' ? 'bg-blue-100 text-blue-600' : ($activity->status == 'returned' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500') }}">
                                            @if($activity->status == 'borrowed')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            @elseif($activity->status == 'returned')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>
                                        @if(!$loop->last)
                                            <div class="w-px h-full bg-slate-100 mt-2"></div>
                                        @endif
                                    </div>
                                    <div class="pb-6">
                                        <p class="text-sm text-slate-800">
                                            You <span class="font-bold {{ $activity->status == 'borrowed' ? 'text-blue-600' : 'text-emerald-600' }}">{{ $activity->status }}</span> 
                                            <span class="font-semibold">"{{ $activity->book->title }}"</span>
                                        </p>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $activity->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-sm text-slate-500">No recent activity to show.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column (Narrower) -->
        <div class="space-y-6 xl:space-y-8">
            
            <!-- Unpaid Fines Alert -->
            @if($unpaidFines->count() > 0)
            <div class="bg-rose-50 border border-rose-100 rounded-3xl p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-200/50 rounded-full blur-2xl"></div>
                
                <div class="flex items-center justify-between mb-4 relative z-10">
                    <h3 class="text-base font-bold text-rose-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Unpaid Fines
                    </h3>
                    <span class="bg-rose-100 text-rose-700 text-xs font-bold px-2 py-1 rounded-md">{{ $unpaidFines->count() }}</span>
                </div>
                
                <div class="space-y-3 relative z-10">
                    @foreach($unpaidFines->take(3) as $fine)
                        <div class="bg-white/80 backdrop-blur rounded-xl p-3 shadow-sm border border-rose-50 flex items-center justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-800 line-clamp-1" title="{{ $fine->borrowing->book->title }}">{{ $fine->borrowing->book->title }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">Due: {{ $fine->borrowing->due_date->format('M d') }}</p>
                            </div>
                            <p class="text-sm font-bold text-rose-600 whitespace-nowrap">Rs. {{ number_format($fine->amount, 2) }}</p>
                        </div>
                    @endforeach
                </div>
                
                @if($unpaidFines->count() > 3)
                    <a href="#" class="block text-center text-xs font-semibold text-rose-600 mt-4 hover:text-rose-700">View all fines ({{ $unpaidFines->count() }})</a>
                @endif
            </div>
            @endif

            <!-- Pending Requests -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-slate-800">Pending Requests</h3>
                    @if($pendingRequests->count() > 0)
                        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2 py-1 rounded-md">{{ $pendingRequests->count() }}</span>
                    @endif
                </div>
                
                @if($pendingRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingRequests->take(5) as $request)
                            <div class="flex gap-3 items-center group cursor-default">
                                <div class="w-12 h-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 shadow-sm border border-slate-100">
                                    @if($request->book->cover_image)
                                        <img src="{{ Storage::url($request->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 line-clamp-1 group-hover:text-amber-600 transition-colors" title="{{ $request->book->title }}">{{ $request->book->title }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Req: {{ $request->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="w-2 h-2 rounded-full bg-amber-400" title="Pending"></div>
                            </div>
                        @endforeach
                    </div>
                    @if($pendingRequests->count() > 5)
                        <a href="#" class="block text-center text-xs font-semibold text-emerald-600 mt-4 hover:text-emerald-700">View all {{ $pendingRequests->count() }} requests</a>
                    @endif
                @else
                    <div class="text-center py-6 bg-slate-50/50 rounded-2xl border border-slate-50">
                        <p class="text-sm text-slate-500">No pending requests.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
