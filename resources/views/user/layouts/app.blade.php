<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-gradient-accent {
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex flex-col relative selection:bg-emerald-500/30 selection:text-emerald-900" x-data="{ mobileMenuOpen: false }">

    <!-- Abstract Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-blue-400/10 blur-[120px]"></div>
    </div>

    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-md border-b border-white shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-gradient-accent flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-slate-800 tracking-tight">Library<span class="text-emerald-500">MS</span></span>
                    </a>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded-xl {{ request()->routeIs('user.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} font-semibold text-sm transition-colors">Dashboard</a>
                        <a href="{{ route('user.books.index') }}" class="px-4 py-2 rounded-xl {{ request()->routeIs('user.books.index') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} font-medium text-sm transition-colors">Explore Books</a>
                        <a href="#" class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors">My Borrowings</a>
                    </div>
                </div>

                <!-- Right Side (User Menu & Notifications) -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors hidden sm:block">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @php
                            $pendingReqs = App\Models\BorrowRequest::where('user_id', Auth::id())->where('status', 'pending')->count();
                            $unpaid = App\Models\Fine::where('user_id', Auth::id())->where('status', 'unpaid')->count();
                        @endphp
                        @if($pendingReqs > 0 || $unpaid > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
                        @endif
                    </button>

                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group p-1 pr-2 rounded-full hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center shadow-sm">
                                <span class="text-sm font-bold text-emerald-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-slate-700 group-hover:text-emerald-600 transition-colors">{{ explode(' ', Auth::user()->name)[0] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-slate-100 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-50 mb-2">
                                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden ml-2">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 hover:text-emerald-600 focus:outline-none p-2 rounded-lg hover:bg-slate-50">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="mobileMenuOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white/95 backdrop-blur-md border-b border-slate-100 absolute w-full shadow-lg z-40">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} font-semibold text-base">Dashboard</a>
                <a href="{{ route('user.books.index') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.books.index') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} font-medium text-base">Explore Books</a>
                <a href="#" class="block px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium text-base">My Borrowings</a>
                <div class="border-t border-slate-100 my-2 pt-2">
                    <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium text-base">
                        <span>Notifications</span>
                        @if($pendingReqs > 0 || $unpaid > 0)
                            <span class="bg-rose-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingReqs + $unpaid }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-8 border-t border-slate-200/60 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-slate-800 transition-colors">Privacy</a>
                <a href="#" class="hover:text-slate-800 transition-colors">Terms</a>
                <a href="#" class="hover:text-slate-800 transition-colors">Support</a>
            </div>
        </div>
    </footer>
</body>
</html>
