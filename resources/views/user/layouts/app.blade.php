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
                        <a href="{{ route('user.books.index') }}" class="px-4 py-2 rounded-xl {{ request()->routeIs('user.books.index') || request()->routeIs('user.books.show') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} font-medium text-sm transition-colors">Explore Books</a>
                        <a href="{{ route('user.borrowings.index') }}" class="px-4 py-2 rounded-xl {{ request()->routeIs('user.borrowings.index') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} font-medium text-sm transition-colors">My Borrowings</a>
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
                            <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-colors">
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
                <a href="{{ route('user.books.index') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.books.index') || request()->routeIs('user.books.show') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} font-medium text-base">Explore Books</a>
                <a href="{{ route('user.borrowings.index') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.borrowings.index') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }} font-medium text-base">My Borrowings</a>
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

    <!-- Beautiful Footer -->
    <footer class="mt-auto relative z-10 overflow-hidden bg-white/70 backdrop-blur-xl border-t border-white shadow-[0_-4px_25px_rgba(0,0,0,0.03)]">
        <!-- Abstract Footer Background -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full -z-10 pointer-events-none opacity-40">
            <div class="absolute -bottom-[50%] -left-[10%] w-[40%] h-[100%] rounded-full bg-emerald-300/20 blur-[80px]"></div>
            <div class="absolute -bottom-[50%] -right-[10%] w-[40%] h-[100%] rounded-full bg-blue-300/20 blur-[80px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Brand Section -->
                <div class="lg:col-span-1 space-y-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group inline-block">
                        <div class="w-10 h-10 rounded-xl bg-gradient-accent flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-slate-800 tracking-tight">Library<span class="text-emerald-500">MS</span></span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Empowering readers and streamlining library operations with our modern, efficient management system.
                    </p>
                    <div class="flex items-center gap-4 pt-2">
                        <!-- Social Icons -->
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-500 transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-500 transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.016 18.6h-1.894v-5.592c0-1.334-.025-3.05-1.859-3.05-1.861 0-2.146 1.454-2.146 2.955v5.687h-1.894v-11.2h1.817v1.53h.026c.253-.478.869-.982 1.789-.982 1.913 0 2.266 1.258 2.266 2.894v7.758zM4.784 5.926c-.609 0-1.103-.494-1.103-1.103s.494-1.103 1.103-1.103 1.103.494 1.103 1.103-.494 1.103-1.103 1.103zm.947 12.674H3.837v-11.2h1.894v11.2z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div>
                    <h3 class="font-bold text-slate-800 tracking-wide mb-5">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('user.dashboard') }}" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Dashboard</a></li>
                        <li><a href="{{ route('user.books.index') }}" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Explore Books</a></li>
                        <li><a href="{{ route('user.borrowings.index') }}" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">My Borrowings</a></li>
                        <li><a href="{{ route('user.profile.edit') }}" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">My Profile</a></li>
                    </ul>
                </div>

                <!-- Resources Links -->
                <div>
                    <h3 class="font-bold text-slate-800 tracking-wide mb-5">Resources</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Help Center</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Library Rules</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Suggest a Book</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors inline-block">Reading Lists</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="font-bold text-slate-800 tracking-wide mb-5">Get in Touch</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-sm text-slate-500">123 Library Way, Reading Avenue<br>Cityville, State 12345</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:support@libraryms.com" class="text-sm text-slate-500 hover:text-emerald-600 transition-colors">support@libraryms.com</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-sm text-slate-500">+1 (555) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </footer>
</body>
</html>
