<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System — Your Digital Library</title>
    <meta name="description"
        content="A modern Library Management System. Browse, borrow, and manage books with ease. Register now to access thousands of titles.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        /* ── Keyframes ── */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-18px)
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0) rotate(0deg)
            }

            50% {
                transform: translateY(-12px) rotate(3deg)
            }
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(32px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes slide-right {
            from {
                opacity: 0;
                transform: translateX(-40px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%)
            }

            100% {
                transform: translateX(100%)
            }
        }

        @keyframes pulse-soft {

            0%,
            100% {
                opacity: .25
            }

            50% {
                opacity: .45
            }
        }

        @keyframes count-up {
            from {
                opacity: 0;
                transform: translateY(16px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes orbit {
            0% {
                transform: rotate(0deg) translateX(140px) rotate(0deg)
            }

            100% {
                transform: rotate(360deg) translateX(140px) rotate(-360deg)
            }
        }

        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }
        }

        .animate-fade-up {
            animation: fade-up .8s ease-out both
        }

        .animate-fade-in {
            animation: fade-in .6s ease-out both
        }

        .animate-slide-right {
            animation: slide-right .7s ease-out both
        }

        .animate-count-up {
            animation: count-up .6s ease-out both
        }

        .delay-100 {
            animation-delay: .1s
        }

        .delay-200 {
            animation-delay: .2s
        }

        .delay-300 {
            animation-delay: .3s
        }

        .delay-400 {
            animation-delay: .4s
        }

        .delay-500 {
            animation-delay: .5s
        }

        .delay-600 {
            animation-delay: .6s
        }

        /* Gradient text helper */
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animated gradient border */
        .gradient-border {
            position: relative;
            background: rgba(255, 255, 255, .7);
            backdrop-filter: blur(20px);
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6, #10b981);
            background-size: 300% 300%;
            animation: gradient-x 6s ease infinite;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Nav blur */
        .nav-blur {
            backdrop-filter: blur(16px) saturate(180%);
        }

        /* Scroll reveal via JS */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all .7s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Feature card hover glow */
        .feature-card {
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(16, 185, 129, .15);
        }

        /* Step connector line */
        .step-connector {
            position: relative;
        }

        .step-connector::after {
            content: '';
            position: absolute;
            top: 28px;
            left: calc(50% + 36px);
            width: calc(100% - 72px);
            height: 2px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            opacity: .3;
        }

        .step-connector:last-child::after {
            display: none;
        }

        /* Mobile nav */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
        }

        .mobile-menu.open {
            max-height: 400px;
        }
    </style>
</head>

<body class="bg-slate-50 antialiased min-h-screen overflow-x-hidden">

    <!-- ═══════════════════ NAVIGATION ═══════════════════ -->
    <nav id="navbar"
        class="fixed top-0 left-0 right-0 z-50 nav-blur bg-white/70 border-b border-slate-200/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group" id="nav-logo">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-blue-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-800">Library<span
                            class="text-emerald-600">MS</span></span>
                </a>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features"
                        class="text-sm font-medium text-slate-600 hover:text-emerald-600 transition-colors"
                        id="nav-features">Features</a>
                    <a href="#how-it-works"
                        class="text-sm font-medium text-slate-600 hover:text-emerald-600 transition-colors"
                        id="nav-how-it-works">How It Works</a>
                    <a href="#stats" class="text-sm font-medium text-slate-600 hover:text-emerald-600 transition-colors"
                        id="nav-stats">Stats</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-slate-700 hover:text-emerald-600 px-4 py-2 rounded-lg hover:bg-emerald-50 transition-all"
                        id="nav-login">Log In</a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-blue-600 hover:from-emerald-400 hover:to-blue-500 px-5 py-2.5 rounded-lg shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all transform hover:-translate-y-0.5"
                        id="nav-register">Get Started</a>
                </div>

                <!-- Mobile hamburger -->
                <button onclick="document.getElementById('mobile-nav').classList.toggle('open')"
                    class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors" id="mobile-menu-toggle">
                    <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-nav" class="mobile-menu md:hidden">
                <div class="py-4 space-y-2 border-t border-slate-200/60">
                    <a href="#features"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Features</a>
                    <a href="#how-it-works"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">How
                        It Works</a>
                    <a href="#stats"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Stats</a>
                    <div class="pt-2 flex flex-col gap-2">
                        <a href="{{ route('login') }}"
                            class="text-center text-sm font-semibold text-slate-700 px-4 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">Log
                            In</a>
                        <a href="{{ route('register') }}"
                            class="text-center text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-blue-600 px-4 py-2.5 rounded-lg shadow-md">Get
                            Started</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- ═══════════════════ HERO SECTION ═══════════════════ -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        <!-- Background blobs -->
        <div class="absolute top-[-15%] left-[-10%] w-[50%] h-[50%] bg-emerald-400 rounded-full mix-blend-multiply filter blur-[120px] opacity-20"
            style="animation: pulse-soft 6s ease-in-out infinite;"></div>
        <div class="absolute bottom-[-15%] right-[-10%] w-[45%] h-[45%] bg-blue-500 rounded-full mix-blend-multiply filter blur-[120px] opacity-20"
            style="animation: pulse-soft 6s ease-in-out infinite; animation-delay:3s;"></div>
        <div class="absolute top-[30%] right-[20%] w-[25%] h-[25%] bg-violet-400 rounded-full mix-blend-multiply filter blur-[100px] opacity-15"
            style="animation: pulse-soft 8s ease-in-out infinite; animation-delay:1.5s;"></div>

        <!-- Floating decorators -->
        <div class="absolute top-24 left-8 lg:left-20 text-emerald-300 opacity-30"
            style="animation: float 7s ease-in-out infinite;">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z" />
            </svg>
        </div>
        <div class="absolute bottom-16 right-8 lg:right-24 text-blue-300 opacity-30"
            style="animation: float-slow 9s ease-in-out infinite; animation-delay:2s;">
            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z" />
            </svg>
        </div>
        <div class="absolute top-48 right-[15%] text-violet-300 opacity-20 hidden lg:block"
            style="animation: float 10s ease-in-out infinite; animation-delay:4s;">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left: Copy -->
                <div class="text-center lg:text-left">
                    <div class="animate-fade-up">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold tracking-wide uppercase mb-6">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Open for Registration
                        </span>
                    </div>

                    <h1
                        class="animate-fade-up delay-100 text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                        Your Personal
                        <span class="text-gradient">Digital Library</span>
                        Experience
                    </h1>

                    <p
                        class="animate-fade-up delay-200 mt-6 text-lg sm:text-xl text-slate-500 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Discover, borrow, and manage books effortlessly. Our smart library system keeps track of
                        everything — so you can focus on reading.
                    </p>

                    <div
                        class="animate-fade-up delay-300 mt-10 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-blue-600 rounded-xl shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:from-emerald-400 hover:to-blue-500 transition-all transform hover:-translate-y-0.5"
                            id="hero-register">
                            Create Free Account
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-slate-300 transition-all"
                            id="hero-login">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Sign In
                        </a>
                    </div>

                    <!-- Trust indicators -->
                    <div
                        class="animate-fade-up delay-400 mt-10 flex items-center gap-6 justify-center lg:justify-start text-slate-400 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Free to join</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Instant access</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>No card needed</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Hero visual -->
                <div class="animate-fade-up delay-300 relative flex items-center justify-center">
                    <div class="relative w-full max-w-md mx-auto">
                        <!-- Orbiting ring -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div
                                class="w-72 h-72 lg:w-80 lg:h-80 rounded-full border border-dashed border-emerald-200/50">
                            </div>
                        </div>

                        <!-- Central card -->
                        <div class="gradient-border rounded-2xl p-8 text-center relative z-10 mx-8">
                            <div
                                class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-blue-600 flex items-center justify-center shadow-2xl shadow-emerald-500/30 mb-6">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Smart Library</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">Browse catalogs, borrow books, track due
                                dates — everything in one beautiful dashboard.</p>

                            <!-- Mini stat badges -->
                            <div class="flex items-center justify-center gap-3 mt-6">
                                <span
                                    class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">📚
                                    Books</span>
                                <span class="px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">📖
                                    Borrow</span>
                                <span class="px-3 py-1.5 rounded-full bg-violet-50 text-violet-700 text-xs font-bold">⭐
                                    Track</span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════ FEATURED BOOKS ═══════════════════ -->
    <section id="featured-books" class="py-20 lg:py-28 relative bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold tracking-wide uppercase mb-4">Discover</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Featured <span class="text-gradient">Books</span></h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">Explore some of our latest and most popular additions to the library.</p>
            </div>
            
            @if(isset($featuredBooks) && $featuredBooks->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($featuredBooks as $book)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full reveal" style="animation-delay: {{ $loop->index * 50 }}ms">
                    <div class="aspect-[2/3] w-full bg-slate-100 relative overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        @if($book->category)
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-white bg-black/50 backdrop-blur-md rounded-md">{{ $book->category->name }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 group-hover:text-emerald-600 transition-colors">{{ $book->title }}</h3>
                        @if($book->author)
                        <p class="text-xs text-slate-500 mb-3">{{ $book->author->name }}</p>
                        @endif
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-medium {{ $book->available_copies > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $book->available_copies > 0 ? 'Available' : 'Out of stock' }}
                            </span>
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-white bg-emerald-500 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center text-slate-500 py-10 bg-slate-50 rounded-2xl border border-slate-200">
                <p>No featured books available at the moment.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- ═══════════════════ FEATURES ═══════════════════ -->
    <section id="features" class="py-20 lg:py-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section header -->
            <div class="text-center mb-16 reveal">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold tracking-wide uppercase mb-4">Features</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Everything You Need to <span
                        class="text-gradient">Manage Your Reading</span></h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">Our library system is packed with features that
                    make borrowing, tracking, and discovering books a breeze.</p>
            </div>

            <!-- Feature grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="feature-card reveal bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Smart Book Search</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Find any book in seconds. Search by title,
                            author, category, or ISBN across our entire catalog.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card reveal delay-100 bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Easy Borrowing</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Request to borrow books with a single click.
                            Track your borrowing history and manage returns effortlessly.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card reveal delay-200 bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-violet-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center shadow-lg shadow-violet-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Due Date Tracking</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Never miss a return date. Get clear visibility
                            on all your due dates and avoid late fines.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div
                    class="feature-card reveal delay-100 bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Category Browsing</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Explore books organized by categories —
                            fiction, science, history, and more. Discover your next read.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div
                    class="feature-card reveal delay-200 bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-rose-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-600 flex items-center justify-center shadow-lg shadow-rose-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Fine Management</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Transparent fine tracking if you miss a
                            return. View, understand, and clear your fines easily.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div
                    class="feature-card reveal delay-300 bg-white/70 backdrop-blur-sm border border-slate-200/80 rounded-2xl p-7 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-cyan-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-teal-600 flex items-center justify-center shadow-lg shadow-cyan-500/20 mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Personal Dashboard</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Your personalized hub shows borrowed books,
                            pending requests, reading stats, and account details at a glance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════ STATS ═══════════════════ -->
    <section id="stats" class="py-20 relative overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        <div class="absolute inset-0 opacity-5"
            style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 reveal">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wide uppercase mb-4">By
                    The Numbers</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Trusted by <span
                        class="text-gradient">Readers & Institutions</span></h2>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div
                    class="reveal text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2">{{ number_format($totalBooks) }}
                    </div>
                    <p class="text-sm text-slate-400 font-medium">Books Available</p>
                </div>
                <div
                    class="reveal delay-100 text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="text-4xl sm:text-5xl font-extrabold text-emerald-400 mb-2">
                        {{ number_format($totalMembers) }}</div>
                    <p class="text-sm text-slate-400 font-medium">Active Members</p>
                </div>
                <div
                    class="reveal delay-200 text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="text-4xl sm:text-5xl font-extrabold text-blue-400 mb-2">
                        {{ number_format($totalCategories) }}</div>
                    <p class="text-sm text-slate-400 font-medium">Categories</p>
                </div>
                <div
                    class="reveal delay-300 text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="text-4xl sm:text-5xl font-extrabold text-violet-400 mb-2">
                        {{ number_format($totalAuthors) }}</div>
                    <p class="text-sm text-slate-400 font-medium">Authors</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════ HOW IT WORKS ═══════════════════ -->
    <section id="how-it-works" class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-50 border border-violet-200 text-violet-700 text-xs font-semibold tracking-wide uppercase mb-4">How
                    It Works</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Get Started in <span
                        class="text-gradient">Three Simple Steps</span></h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">From registration to your first borrowed book —
                    it only takes minutes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="reveal text-center step-connector">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-xl font-bold shadow-lg shadow-emerald-500/25 mb-6">
                        1</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Create an Account</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Register with your name, email, and password. It's
                        completely free and takes less than a minute.</p>
                </div>

                <!-- Step 2 -->
                <div class="reveal delay-200 text-center step-connector">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white text-xl font-bold shadow-lg shadow-blue-500/25 mb-6">
                        2</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Browse & Discover</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Explore our vast catalog. Search by title, author,
                        or category to find exactly what you want to read.</p>
                </div>

                <!-- Step 3 -->
                <div class="reveal delay-400 text-center step-connector">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-violet-500 to-violet-600 text-white text-xl font-bold shadow-lg shadow-violet-500/25 mb-6">
                        3</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Borrow & Enjoy</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Request a book, pick it up, and enjoy reading.
                        Track everything from your personal dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════ CTA ═══════════════════ -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-blue-600 to-violet-600"></div>
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cmVjdCB3aWR0aD0iMSIgaGVpZ2h0PSI0MCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-50">
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">Ready to Start Your
                <br>Reading Journey?</h2>
            <p class="mt-6 text-lg text-white/80 max-w-2xl mx-auto">Join our community of passionate readers. Create
                your free account today and unlock the full library experience.</p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-4 text-base font-bold text-emerald-700 bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-0.5"
                    id="cta-register">
                    Register Now — It's Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-4 text-base font-bold text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition-all"
                    id="cta-login">
                    Already a Member? Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════ FOOTER ═══════════════════ -->
    <footer class="bg-slate-900 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Links (Safety Guidelines & Privacy Policy) -->
                <div class="flex gap-6">
                    <a href="{{ route('safety') }}" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors">Safety
                        Guidelines</a>
                    <a href="{{ route('privacy') }}" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors">Privacy
                        Policy</a>
                </div>

                <!-- Contact info (Email & Contact) -->
                <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <a href="mailto:support@libraryms.com"
                        class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        support@libraryms.com
                    </a>
                    <span class="text-sm text-slate-400 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        +977 9800000000
                    </span>
                </div>

                <!-- Social Media -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.016 18.6h-1.894v-5.592c0-1.334-.025-3.05-1.859-3.05-1.861 0-2.146 1.454-2.146 2.955v5.687h-1.894v-11.2h1.817v1.53h.026c.253-.478.869-.982 1.789-.982 1.913 0 2.266 1.258 2.266 2.894v7.758zM4.784 5.926c-.609 0-1.103-.494-1.103-1.103s.494-1.103 1.103-1.103 1.103.494 1.103 1.103-.494 1.103-1.103 1.103zm.947 12.674H3.837v-11.2h1.894v11.2z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </footer>

    <!-- ═══════════════════ SCRIPTS ═══════════════════ -->
    <script>
        // ── Intersection Observer for scroll reveal ──
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ── Navbar shadow on scroll ──
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md', 'bg-white/90');
                navbar.classList.remove('bg-white/70');
            } else {
                navbar.classList.remove('shadow-md', 'bg-white/90');
                navbar.classList.add('bg-white/70');
            }
        });

        // ── Close mobile menu on link click ──
        document.querySelectorAll('#mobile-nav a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-nav').classList.remove('open');
            });
        });
    </script>
</body>

</html>