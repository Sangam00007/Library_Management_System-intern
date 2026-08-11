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



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Wider) -->
        <div class="lg:col-span-2 space-y-8">
            
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
        <div class="space-y-6 lg:space-y-8">
            
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

    <!-- Featured Books Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                Featured Books
            </h2>
            <a href="{{ route('user.books.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1">
                View catalog
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($featuredBooks as $book)
                <a href="{{ route('user.books.show', $book) }}" class="group flex flex-col h-full cursor-pointer">
                    <div class="w-full aspect-[2/3] bg-slate-100 rounded-xl overflow-hidden shadow-sm group-hover:shadow-lg group-hover:shadow-emerald-500/10 transition-all duration-300 relative border border-slate-100 group-hover:border-emerald-200 group-hover:-translate-y-1">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                            <span class="text-white text-xs font-semibold">View Details</span>
                        </div>
                    </div>
                    <div class="mt-3 flex-1 flex flex-col">
                        <h4 class="text-sm font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-emerald-700 transition-colors">{{ $book->title }}</h4>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $book->author->name ?? 'Unknown' }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-slate-100">
                    <p class="text-slate-500 font-medium">No featured books available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Latest Additions Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                Latest Additions
            </h2>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($latestBooks as $book)
                <a href="{{ route('user.books.show', $book) }}" class="group flex flex-col h-full cursor-pointer">
                    <div class="w-full aspect-[2/3] bg-slate-100 rounded-xl overflow-hidden shadow-sm group-hover:shadow-lg group-hover:shadow-blue-500/10 transition-all duration-300 relative border border-slate-100 group-hover:border-blue-200 group-hover:-translate-y-1">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                            <span class="text-white text-xs font-semibold">View Details</span>
                        </div>
                    </div>
                    <div class="mt-3 flex-1 flex flex-col">
                        <h4 class="text-sm font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-blue-700 transition-colors">{{ $book->title }}</h4>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $book->author->name ?? 'Unknown' }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-slate-100">
                    <p class="text-slate-500 font-medium">No recent additions at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
