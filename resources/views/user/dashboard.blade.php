<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, *::before, *::after { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        
        .nav-blur { backdrop-filter: blur(16px) saturate(180%); }
        .card-glow { transition: box-shadow 0.3s ease, transform 0.3s ease; }
        .card-glow:hover { box-shadow: 0 20px 40px -12px rgba(16,185,129,0.15); transform: translateY(-4px); }
        
        @keyframes pulse-soft { 0%,100% { opacity:0.1 } 50% { opacity:0.3 } }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900 min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Background Decorators -->
    <div class="fixed top-[-20%] left-[-10%] w-[50%] h-[50%] bg-emerald-400 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 pointer-events-none" style="animation: pulse-soft 8s ease-in-out infinite;"></div>
    <div class="fixed bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-blue-500 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 pointer-events-none" style="animation: pulse-soft 8s ease-in-out infinite; animation-delay: 4s;"></div>

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 nav-blur bg-white/70 border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-blue-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-slate-800 hidden sm:block">Library<span class="text-emerald-600">MS</span></span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('user.dashboard') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }} transition-colors">Dashboard</a>
                    <!-- Add more links here like Catalog, My Borrowings etc if routes exist -->
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none bg-white border border-slate-200 rounded-full pl-2 pr-4 py-1.5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-sm font-bold text-emerald-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 hidden sm:block">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 mb-2">
                                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
        
        <!-- Welcome Header -->
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Welcome back, <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-blue-600">{{ Auth::user()->name }}</span>! 👋
            </h1>
            <p class="mt-2 text-lg text-slate-500">Here's a quick overview of your reading journey.</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Card: Active Borrowings -->
            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 card-glow relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Currently Borrowed</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $activeBorrowings->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card: Total Read -->
            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 card-glow relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Books Read</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalReturned }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card: Pending Requests -->
            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 card-glow relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pending Requests</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $pendingRequests->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card: Fines -->
            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 card-glow relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Unpaid Fines</p>
                        <p class="text-3xl font-extrabold {{ $totalFinesAmount > 0 ? 'text-rose-600' : 'text-slate-800' }} mt-2">Rs. {{ number_format($totalFinesAmount, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl {{ $totalFinesAmount > 0 ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Active & Recent -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Currently Borrowed -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Currently Reading
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($activeBorrowings->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeBorrowings as $borrowing)
                                    <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white hover:border-blue-200 hover:shadow-md transition-all group">
                                        <div class="w-16 h-20 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200">
                                            @if($borrowing->book->cover_image)
                                                <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-semibold text-slate-800 truncate group-hover:text-blue-600 transition-colors">{{ $borrowing->book->title }}</h3>
                                            <p class="text-sm text-slate-500 mt-1 truncate">Borrowed on: {{ $borrowing->borrow_date->format('M d, Y') }}</p>
                                            
                                            @php
                                                $daysLeft = now()->diffInDays($borrowing->due_date, false);
                                            @endphp
                                            
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $daysLeft < 0 ? 'bg-rose-100 text-rose-800' : ($daysLeft <= 3 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                                    @if($daysLeft < 0)
                                                        Overdue by {{ abs(intval($daysLeft)) }} days
                                                    @elseif($daysLeft == 0)
                                                        Due today
                                                    @else
                                                        {{ intval($daysLeft) }} days left
                                                    @endif
                                                </span>
                                                <span class="text-xs text-slate-400">Due: {{ $borrowing->due_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h3 class="text-base font-semibold text-slate-700">No active borrowings</h3>
                                <p class="text-sm text-slate-500 mt-1">You aren't currently reading any books.</p>
                                <a href="#" class="inline-flex items-center justify-center mt-4 px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">Browse Catalog</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800">Recent Activity</h2>
                    </div>
                    <div class="p-6">
                        @if($recentActivity->count() > 0)
                            <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                                @foreach($recentActivity as $activity)
                                    <div class="relative pl-6">
                                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $activity->status == 'borrowed' ? 'bg-blue-500' : ($activity->status == 'returned' ? 'bg-emerald-500' : 'bg-slate-400') }}"></span>
                                        <p class="text-sm text-slate-600">
                                            You <span class="font-semibold text-slate-800">{{ $activity->status }}</span> the book 
                                            <span class="font-semibold text-slate-800">"{{ $activity->book->title }}"</span>
                                        </p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $activity->updated_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-500 text-center py-4">No recent activity found.</p>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column: Fines & Requests -->
            <div class="space-y-8">
                
                <!-- Unpaid Fines -->
                @if($unpaidFines->count() > 0)
                <div class="bg-rose-50 border border-rose-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-rose-100 flex justify-between items-center bg-white/50">
                        <h2 class="text-sm font-bold text-rose-800 uppercase tracking-wider">Unpaid Fines</h2>
                        <span class="px-2.5 py-0.5 rounded-full bg-rose-200 text-rose-800 text-xs font-bold">{{ $unpaidFines->count() }}</span>
                    </div>
                    <div class="p-4 space-y-3">
                        @foreach($unpaidFines as $fine)
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-rose-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $fine->borrowing->book->title }}</p>
                                        <p class="text-xs text-slate-500 mt-1">Due Date: {{ $fine->borrowing->due_date->format('M d, Y') }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-rose-600">Rs. {{ number_format($fine->amount, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pending Requests -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Pending Requests</h2>
                        @if($pendingRequests->count() > 0)
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">{{ $pendingRequests->count() }}</span>
                        @endif
                    </div>
                    <div class="p-4">
                        @if($pendingRequests->count() > 0)
                            <ul class="space-y-3">
                                @foreach($pendingRequests as $request)
                                    <li class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                                        <div class="w-10 h-14 bg-slate-200 rounded overflow-hidden flex-shrink-0">
                                            @if($request->book->cover_image)
                                                <img src="{{ Storage::url($request->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $request->book->title }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Requested on {{ $request->created_at->format('M d') }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800 uppercase">
                                            Pending
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-6">
                                <p class="text-sm text-slate-500">No pending requests.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-900 transition-colors">Help & Support</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-900 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
