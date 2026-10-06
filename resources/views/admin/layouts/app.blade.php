<!DOCTYPE html>
<html lang="en" :class="{ 'dark': darkMode }" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&dm-serif-display:400&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-surface-50 dark:bg-surface-950 font-sans antialiased text-slate-900 dark:text-slate-200 flex min-h-screen overflow-hidden selection:bg-accent-500/30 transition-colors duration-300" x-data="{ sidebarOpen: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }">

    <!-- Background Decorators -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-accent-400 dark:bg-accent-500 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[120px] opacity-10 dark:opacity-5 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-mustard-300 dark:bg-mustard-500 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[120px] opacity-10 dark:opacity-5 pointer-events-none" style="animation-delay: 2s;"></div>

    <!-- Sidebar -->
    <aside
        class="bg-slate-800 dark:bg-surface-900 backdrop-blur-xl border-r border-slate-700/50 dark:border-white/5 flex flex-col transition-all duration-300 z-40 fixed inset-y-0 left-0 lg:static"
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            sidebarCollapsed ? 'w-[4.5rem]' : 'w-64'
        ]"
    >
        <!-- Logo -->
        <div class="h-16 flex items-center border-b border-slate-700/50 dark:border-white/5" :class="sidebarCollapsed ? 'px-4 justify-center' : 'px-6'">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center shadow-lg shadow-accent-500/20 shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span x-show="!sidebarCollapsed" x-transition class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-accent-400 to-accent-200 whitespace-nowrap">Library Admin</span>
            </div>
        </div>

        <!-- Collapse toggle (desktop only) -->
        <button
            @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)"
            class="hidden lg:flex items-center justify-center h-8 mx-3 mt-3 rounded-lg text-slate-500 hover:text-slate-300 hover:bg-slate-700/50 transition-all"
            :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
            <svg class="w-4 h-4 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
        </button>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group" :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm">Dashboard</span>
            </a>

            <!-- Catalog Section (Collapsible) -->
            <div x-data="{ catalogOpen: {{ request()->routeIs('admin.books.*') || request()->routeIs('admin.authors.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.publishers.*') ? 'true' : 'true' }} }">
                <button x-show="!sidebarCollapsed" @click="catalogOpen = !catalogOpen" class="w-full flex items-center justify-between px-3 pt-5 pb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Catalog</p>
                    <svg class="w-3.5 h-3.5 text-slate-500 transition-transform duration-200" :class="catalogOpen ? 'rotate-0' : '-rotate-90'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="!sidebarCollapsed" x-collapse x-cloak>
                    <div class="space-y-1" x-show="catalogOpen">
                        <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.books.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.books.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="font-medium text-sm">Books</span>
                        </a>
                        <a href="{{ route('admin.authors.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.authors.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.authors.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="font-medium text-sm">Authors</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            <span class="font-medium text-sm">Categories</span>
                        </a>
                        <a href="{{ route('admin.publishers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.publishers.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.publishers.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="font-medium text-sm">Publishers</span>
                        </a>
                    </div>
                </div>
                <!-- Collapsed icons -->
                <div x-show="sidebarCollapsed" class="space-y-1 mt-2">
                    <a href="{{ route('admin.books.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.books.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Books">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </a>
                    <a href="{{ route('admin.authors.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.authors.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Authors">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Categories">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </a>
                    <a href="{{ route('admin.publishers.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.publishers.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Publishers">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Circulation Section (Collapsible) -->
            <div x-data="{ circulationOpen: {{ request()->routeIs('admin.borrow_requests.*') || request()->routeIs('admin.borrowings.*') || request()->routeIs('admin.fines.*') ? 'true' : 'true' }} }">
                <button x-show="!sidebarCollapsed" @click="circulationOpen = !circulationOpen" class="w-full flex items-center justify-between px-3 pt-5 pb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Circulation</p>
                    <svg class="w-3.5 h-3.5 text-slate-500 transition-transform duration-200" :class="circulationOpen ? 'rotate-0' : '-rotate-90'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="!sidebarCollapsed" x-collapse x-cloak>
                    <div class="space-y-1" x-show="circulationOpen">
                        <a href="{{ route('admin.borrow_requests.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrow_requests.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.borrow_requests.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span class="font-medium text-sm">Borrow Requests</span>
                            @php $pendingCount = \App\Models\BorrowRequest::where('status', 'pending')->count(); @endphp
                            @if($pendingCount > 0)
                                <span class="ml-auto bg-accent-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.borrowings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrowings.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.borrowings.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            <span class="font-medium text-sm">Borrowings</span>
                        </a>
                        <a href="{{ route('admin.fines.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.fines.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all duration-200 group">
                            <div class="w-5 h-5 flex items-center justify-center font-bold text-[13px] leading-none shrink-0 {{ request()->routeIs('admin.fines.*') ? 'text-accent-400' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors">Rs</div>
                            <span class="font-medium text-sm">Fines</span>
                        </a>
                    </div>
                </div>
                <!-- Collapsed icons -->
                <div x-show="sidebarCollapsed" class="space-y-1 mt-2">
                    <a href="{{ route('admin.borrow_requests.index') }}" class="relative flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrow_requests.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Borrow Requests">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        @if($pendingCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-accent-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.borrowings.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.borrowings.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Borrowings">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </a>
                    <a href="{{ route('admin.fines.index') }}" class="flex items-center justify-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.fines.*') ? 'bg-accent-500/20 text-accent-400' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }} transition-all" title="Fines">
                        <div class="w-5 h-5 flex items-center justify-center font-bold text-[13px] leading-none shrink-0">Rs</div>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Mobile Sidebar Backdrop -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/50 dark:bg-black/60 z-30 lg:hidden"
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
        <header class="h-16 bg-white/80 dark:bg-surface-900/80 backdrop-blur-xl border-b border-slate-200/60 dark:border-white/5 flex items-center justify-between px-6 sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white lg:hidden transition-colors" aria-label="Open sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <!-- Breadcrumbs -->
                <nav class="hidden sm:flex items-center text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </a>
                        </li>
                        @hasSection('breadcrumb')
                            <li class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-slate-600 dark:text-slate-300 font-medium">@yield('breadcrumb')</span>
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <!-- Command Palette Trigger -->
                <button
                    @click="$dispatch('open-command-palette')"
                    class="hidden sm:flex items-center gap-2 px-3 py-1.5 text-sm text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-white/5 rounded-lg border border-slate-200 dark:border-white/10 hover:border-accent-300 dark:hover:border-accent-500/30 hover:text-slate-600 dark:hover:text-slate-300 transition-all"
                    aria-label="Open command palette">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <kbd class="text-[10px] font-medium px-1.5 py-0.5 bg-white dark:bg-white/10 rounded border border-slate-200 dark:border-white/10">Ctrl+K</kbd>
                </button>

                <!-- Dark Mode Toggle -->
                <button
                    @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="p-2 rounded-lg text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-all"
                    :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="darkMode" style="display:none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <!-- Admin Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none p-1 rounded-lg hover:bg-slate-50 dark:hover:bg-white/5 transition-colors" aria-label="Admin menu">
                        <img class="h-8 w-8 rounded-full object-cover border border-slate-200 dark:border-white/10" src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name ?? 'Admin') }}&background=0D9488&color=fff" alt="Admin avatar">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden md:block">{{ auth('admin')->user()->name ?? 'Administrator' }}</span>
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-xl shadow-xl dark:shadow-[0_10px_40px_rgba(0,0,0,0.4)] bg-white dark:bg-surface-850 border border-slate-200 dark:border-white/10 py-1 ring-1 ring-black/5 dark:ring-white/5 focus:outline-none">
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-white/5">
                            <p class="text-sm text-slate-900 dark:text-white truncate">{{ auth('admin')->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
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
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl p-4 flex items-center gap-3 animate-slide-in-down" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 animate-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200 transition-colors" aria-label="Dismiss"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl p-4 flex items-center gap-3 animate-slide-in-down" x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-red-700 dark:text-red-300 flex-1">{{ session('error') }}</p>
                    <button @click="show = false" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors" aria-label="Dismiss"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Command Palette (Ctrl+K) -->
    <div x-data="{
            commandOpen: false,
            query: '',
            selectedIndex: 0,
            items: [
                { name: 'Dashboard', url: '{{ route('admin.dashboard') }}', icon: 'dashboard', section: 'Navigation' },
                { name: 'Books', url: '{{ route('admin.books.index') }}', icon: 'book', section: 'Navigation' },
                { name: 'Add New Book', url: '{{ route('admin.books.create') }}', icon: 'plus', section: 'Actions' },
                { name: 'Authors', url: '{{ route('admin.authors.index') }}', icon: 'users', section: 'Navigation' },
                { name: 'Add New Author', url: '{{ route('admin.authors.create') }}', icon: 'plus', section: 'Actions' },
                { name: 'Categories', url: '{{ route('admin.categories.index') }}', icon: 'tag', section: 'Navigation' },
                { name: 'Add New Category', url: '{{ route('admin.categories.create') }}', icon: 'plus', section: 'Actions' },
                { name: 'Publishers', url: '{{ route('admin.publishers.index') }}', icon: 'building', section: 'Navigation' },
                { name: 'Add New Publisher', url: '{{ route('admin.publishers.create') }}', icon: 'plus', section: 'Actions' },
                { name: 'Borrow Requests', url: '{{ route('admin.borrow_requests.index') }}', icon: 'clipboard', section: 'Navigation' },
                { name: 'Borrowings', url: '{{ route('admin.borrowings.index') }}', icon: 'exchange', section: 'Navigation' },
                { name: 'Fines', url: '{{ route('admin.fines.index') }}', icon: 'currency', section: 'Navigation' },
            ],
            get filteredItems() {
                if (!this.query) return this.items;
                return this.items.filter(i => i.name.toLowerCase().includes(this.query.toLowerCase()));
            },
            navigate(url) {
                window.location.href = url;
                this.commandOpen = false;
            }
        }"
        @open-command-palette.window="commandOpen = true; query = ''; selectedIndex = 0; $nextTick(() => $refs.commandInput.focus())"
        @keydown.window.ctrl.k.prevent="commandOpen = true; query = ''; selectedIndex = 0; $nextTick(() => $refs.commandInput.focus())"
        @keydown.escape.window="commandOpen = false">

        <template x-if="commandOpen">
            <div class="fixed inset-0 z-[100]">
                <div class="command-palette-backdrop fixed inset-0" @click="commandOpen = false"></div>
                <div class="relative mx-auto max-w-lg mt-[12vh] px-4">
                    <div class="bg-white dark:bg-surface-850 rounded-2xl shadow-2xl dark:shadow-[0_25px_60px_rgba(0,0,0,0.5)] border border-slate-200 dark:border-white/10 overflow-hidden animate-slide-in-down">
                        <!-- Search Input -->
                        <div class="flex items-center border-b border-slate-100 dark:border-white/5">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 ml-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input
                                x-ref="commandInput"
                                x-model="query"
                                type="text"
                                placeholder="Type a command or search..."
                                class="w-full px-4 py-4 bg-transparent border-0 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-0 text-base command-palette-input"
                                @keydown.arrow-down.prevent="selectedIndex = Math.min(selectedIndex + 1, filteredItems.length - 1)"
                                @keydown.arrow-up.prevent="selectedIndex = Math.max(selectedIndex - 1, 0)"
                                @keydown.enter.prevent="if(filteredItems[selectedIndex]) navigate(filteredItems[selectedIndex].url)"
                                autocomplete="off">
                            <button @click="commandOpen = false" class="px-3 py-1 mr-3 text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-white/10 rounded-lg hover:bg-slate-200 dark:hover:bg-white/15 transition-colors shrink-0">ESC</button>
                        </div>

                        <!-- Results -->
                        <div class="max-h-72 overflow-y-auto custom-scrollbar py-2">
                            <template x-if="filteredItems.length === 0">
                                <div class="px-4 py-8 text-center">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">No results found</p>
                                </div>
                            </template>

                            <template x-for="(item, index) in filteredItems" :key="item.name">
                                <button
                                    @click="navigate(item.url)"
                                    @mouseenter="selectedIndex = index"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-left transition-colors"
                                    :class="selectedIndex === index ? 'bg-accent-50 dark:bg-accent-500/10 text-accent-700 dark:text-accent-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5'">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                         :class="selectedIndex === index ? 'bg-accent-100 dark:bg-accent-500/20 text-accent-600 dark:text-accent-400' : 'bg-slate-100 dark:bg-white/5 text-slate-400 dark:text-slate-500'">
                                        <svg x-show="item.icon === 'plus'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <svg x-show="item.icon !== 'plus'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate" x-text="item.name"></p>
                                        <p class="text-xs opacity-60" x-text="item.section"></p>
                                    </div>
                                    <svg x-show="selectedIndex === index" class="w-4 h-4 shrink-0 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div class="border-t border-slate-100 dark:border-white/5 px-4 py-2.5 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-slate-100 dark:bg-white/10 rounded text-[10px]">↑↓</kbd> Navigate</span>
                                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-slate-100 dark:bg-white/10 rounded text-[10px]">↵</kbd> Open</span>
                                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-slate-100 dark:bg-white/10 rounded text-[10px]">Esc</kbd> Close</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Global Action Confirmation Modal -->
    <div x-data="{
            showConfirmModal: false,
            actionUrl: '',
            httpMethod: 'POST',
            modalTitle: 'Confirm Action',
            modalMessage: 'Are you sure you want to proceed?',
            confirmButtonText: 'Confirm',
            confirmButtonClass: 'bg-accent-600 hover:bg-accent-700 focus:ring-accent-500 shadow-accent-600/20',
            iconType: 'info'
         }"
         @open-confirm-modal.window="
            showConfirmModal = true;
            actionUrl = $event.detail.action;
            httpMethod = $event.detail.method || 'POST';
            modalTitle = $event.detail.title || 'Confirm Action';
            modalMessage = $event.detail.message || 'Are you sure you want to proceed?';
            confirmButtonText = $event.detail.buttonText || 'Confirm';
            confirmButtonClass = $event.detail.buttonClass || 'bg-accent-600 hover:bg-accent-700 focus:ring-accent-500 shadow-accent-600/20';
            iconType = $event.detail.iconType || 'info';
         ">
        <div x-show="showConfirmModal" style="display: none;" class="fixed inset-0 bg-slate-900/50 dark:bg-black/60 backdrop-blur-sm z-[60] transition-opacity"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showConfirmModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-0"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white dark:bg-surface-850 rounded-2xl shadow-xl border border-slate-200 dark:border-white/10 overflow-hidden w-full max-w-md transform transition-all" @click.away="showConfirmModal = false">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full mb-4 mx-auto shadow-inner"
                         :class="{
                            'bg-red-100 dark:bg-red-500/15 shadow-red-200 dark:shadow-none text-red-600 dark:text-red-400': iconType === 'warning',
                            'bg-green-100 dark:bg-green-500/15 shadow-green-200 dark:shadow-none text-green-600 dark:text-green-400': iconType === 'success',
                            'bg-accent-100 dark:bg-accent-500/15 shadow-accent-200 dark:shadow-none text-accent-600 dark:text-accent-400': iconType === 'info'
                         }">
                        <svg x-show="iconType === 'warning'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <svg x-show="iconType === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg x-show="iconType === 'info'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white text-center mb-2" x-text="modalTitle"></h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center" x-html="modalMessage"></p>
                </div>
                <div class="bg-slate-50 dark:bg-white/[0.02] px-6 py-4 flex items-center justify-center gap-3 border-t border-slate-100 dark:border-white/5">
                    <button type="button" @click="showConfirmModal = false" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg hover:bg-slate-50 dark:hover:bg-white/10 transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-slate-200 dark:focus:ring-white/5">Cancel</button>
                    <form method="POST" :action="actionUrl" class="inline m-0">
                        @csrf
                        <input type="hidden" name="_method" :value="httpMethod">
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors shadow-lg focus:ring-2 focus:ring-offset-2 btn-ripple" :class="confirmButtonClass" x-text="confirmButtonText"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false, deleteAction: '', itemName: '' }"
         @open-delete-modal.window="showDeleteModal = true; deleteAction = $event.detail.action; itemName = $event.detail.name">
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 bg-slate-900/50 dark:bg-black/60 backdrop-blur-sm z-[60] transition-opacity"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-0"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white dark:bg-surface-850 rounded-2xl shadow-xl border border-slate-200 dark:border-white/10 overflow-hidden w-full max-w-md transform transition-all" @click.away="showDeleteModal = false">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/15 mb-4 mx-auto shadow-inner shadow-red-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white text-center mb-2">Confirm Deletion</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Are you sure you want to delete <span class="font-semibold text-slate-700 dark:text-slate-200" x-text="itemName"></span>? This action cannot be undone.</p>
                </div>
                <div class="bg-slate-50 dark:bg-white/[0.02] px-6 py-4 flex items-center justify-center gap-3 border-t border-slate-100 dark:border-white/5">
                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg hover:bg-slate-50 dark:hover:bg-white/10 transition-colors">Cancel</button>
                    <form method="POST" :action="deleteAction" class="inline m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors shadow-lg shadow-red-600/20 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-ripple">Yes, delete it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
