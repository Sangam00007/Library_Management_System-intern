<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900 flex min-h-screen overflow-hidden selection:bg-amber-500/30 selection:text-amber-900" x-data="{ sidebarOpen: false }">
    
    <!-- Background Decorators -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-amber-400 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-slate-300 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 pointer-events-none" style="animation-delay: 2s;"></div>

    <!-- Sidebar -->
    <aside 
        class="w-64 bg-slate-800 backdrop-blur-xl border-r border-slate-700/50 flex flex-col transition-transform duration-300 z-40 fixed inset-y-0 left-0 lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="h-16 flex items-center px-6 border-b border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-400 to-amber-200">Library Admin</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            <div class="pt-4 pb-2">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Catalog</p>
            </div>
            
            <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.books.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.books.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-medium text-sm">Books</span>
            </a>
            <a href="{{ route('admin.authors.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.authors.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.authors.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="font-medium text-sm">Authors</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span class="font-medium text-sm">Categories</span>
            </a>
            <a href="{{ route('admin.publishers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.publishers.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.publishers.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="font-medium text-sm">Publishers</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Circulation</p>
            </div>
            
            <a href="{{ route('admin.borrow_requests.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrow_requests.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.borrow_requests.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium text-sm">Borrow Requests</span>
                @php $pendingCount = \App\Models\BorrowRequest::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.borrowings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrowings.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.borrowings.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span class="font-medium text-sm">Borrowings</span>
            </a>
            <a href="{{ route('admin.fines.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.fines.*') ? 'bg-amber-500/20 text-amber-500' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                <div class="w-5 h-5 flex items-center justify-center font-bold text-[13px] leading-none {{ request()->routeIs('admin.fines.*') ? 'text-amber-500' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors">Rs</div>
                <span class="font-medium text-sm">Fines</span>
            </a>
        </nav>
    </aside>

    <!-- Mobile Sidebar Backdrop -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    ></div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen relative z-10">
        <!-- Topbar -->
        <header class="h-16 bg-white backdrop-blur-xl border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-900 lg:hidden transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="relative hidden sm:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-64 pl-9 pr-3 py-1.5 border border-slate-300 rounded-lg leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-colors" placeholder="Search...">
                </div>
            </div>

            <div class="flex items-center gap-4">

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none">
                        <img class="h-8 w-8 rounded-full object-cover border border-slate-200" src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name ?? 'Admin') }}&background=F59E0B&color=fff" alt="Admin avatar">
                        <span class="text-sm font-medium text-slate-700 hidden md:block">{{ auth('admin')->user()->name ?? 'Administrator' }}</span>
                        <svg class="w-4 h-4 text-slate-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-lg shadow-xl bg-white border border-slate-200 py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="px-4 py-2 border-b border-slate-700/50">
                            <p class="text-sm text-slate-900 truncate">{{ auth('admin')->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-6 lg:p-8 custom-scrollbar">
            @if(session('success'))
                <div class="mb-6 bg-emerald-100 border border-emerald-300 rounded-xl p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-emerald-700 flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-300 rounded-xl p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-red-700 flex-1">{{ session('error') }}</p>
                    <button @click="show = false" class="text-red-600 hover:text-red-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }
    </style>
</body>
</html>
