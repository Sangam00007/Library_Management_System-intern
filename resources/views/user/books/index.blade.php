@extends('user.layouts.app')
@section('title', 'Explore Books - Library Management System')

@section('content')
<div class="space-y-10">

    <!-- Header & Search Section -->
    <div class="relative bg-white dark:bg-surface-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden px-6 py-12 sm:p-16 animate-fade-up">
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-accent-400/10 dark:bg-accent-500/5 rounded-full blur-[80px]"></div>
        <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-mustard-400/10 dark:bg-mustard-500/5 rounded-full blur-[80px]"></div>

        <div class="relative z-10 max-w-3xl mx-auto text-center space-y-6">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight font-display">
                Discover your next <br class="hidden sm:block"> <span class="text-gradient">great read.</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg max-w-xl mx-auto">Explore our extensive catalog of books. Search by title, author, or filter by category to find exactly what you're looking for.</p>

            <form action="{{ route('user.books.index') }}" method="GET" class="mt-8">
                <div class="flex flex-col sm:flex-row gap-4 p-2 bg-white/80 dark:bg-white/5 backdrop-blur rounded-2xl sm:rounded-full border border-slate-200 dark:border-white/10 shadow-sm shadow-slate-200/50 dark:shadow-none">

                    <!-- Search Input -->
                    <div class="flex-1 relative flex items-center">
                        <svg class="absolute left-4 w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books, authors..." class="w-full bg-transparent border-0 py-3 pl-12 pr-4 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-accent-500/50 focus:outline-none rounded-xl sm:rounded-full text-base" aria-label="Search books">
                    </div>

                    <div class="hidden sm:block w-px h-8 bg-slate-200 dark:bg-white/10 my-auto"></div>

                    <!-- Category Filter -->
                    <div class="w-full sm:w-48 relative flex items-center border-t border-slate-100 dark:border-white/5 sm:border-0 pt-2 sm:pt-0">
                        <svg class="absolute left-4 w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <select name="category" class="w-full bg-transparent border-0 py-3 pl-12 pr-10 text-slate-900 dark:text-white focus:ring-2 focus:ring-accent-500/50 focus:outline-none appearance-none rounded-xl sm:rounded-full font-medium cursor-pointer" onchange="this.form.submit()" aria-label="Filter by category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-4 w-4 h-4 text-slate-400 dark:text-slate-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-slate-900 dark:bg-accent-600 hover:bg-slate-800 dark:hover:bg-accent-700 text-white font-semibold rounded-xl sm:rounded-full transition-all shadow-lg shadow-slate-900/20 dark:shadow-accent-600/20 active:scale-95 btn-ripple">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                @if(request('search') || request('category'))
                    Search Results <span class="text-slate-400 dark:text-slate-500 text-base font-medium ml-2">({{ $books->total() }} found)</span>
                @else
                    Latest Arrivals
                @endif
            </h2>

            @if(request('search') || request('category'))
                <a href="{{ route('user.books.index') }}" class="text-sm font-semibold text-rose-500 dark:text-rose-400 hover:text-rose-600 dark:hover:text-rose-300 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Clear Filters
                </a>
            @endif
        </div>

        @if($books->count() > 0)
            <div class="grid grid-cols-2 min-[480px]:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                @foreach($books as $book)
                    <a href="{{ route('user.books.show', $book) }}" class="bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 p-3 sm:p-4 shadow-sm hover:shadow-xl hover:shadow-accent-500/5 dark:hover:shadow-accent-500/5 transition-all duration-300 group flex flex-col h-full cursor-pointer relative overflow-hidden card-lift">

                        <!-- Book Cover -->
                        <div class="w-full aspect-[2/3] bg-slate-50 dark:bg-white/[0.02] rounded-2xl mb-4 overflow-hidden shadow-inner dark:shadow-none relative group-hover:shadow-md transition-all">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 dark:text-slate-600 gap-2">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-xs font-medium tracking-widest uppercase">No Cover</span>
                                </div>
                            @endif

                            <!-- Category Badge (Overlay) -->
                            <div class="absolute top-3 left-3 bg-white/90 dark:bg-surface-900/90 backdrop-blur px-2.5 py-1 rounded-lg shadow-sm border border-white/20 dark:border-white/5">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ $book->category->name }}</span>
                            </div>
                        </div>

                        <!-- Book Details -->
                        <div class="flex-1 flex flex-col min-w-0 px-2 pb-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white line-clamp-2 leading-tight group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 line-clamp-1 flex items-center gap-1.5" title="{{ $book->author->name }}">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $book->author->name }}
                            </p>

                            <div class="mt-auto pt-4 flex items-center justify-between">
                                @if($book->available_copies > 0)
                                    <div class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 rounded-lg border border-emerald-100 dark:border-emerald-500/20">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                        <span class="text-xs font-bold">{{ $book->available_copies }} available</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 rounded-lg border border-rose-100 dark:border-rose-500/20">
                                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                        <span class="text-xs font-bold">Unavailable</span>
                                    </div>
                                @endif

                                <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-white/5 flex items-center justify-center text-slate-400 dark:text-slate-500 group-hover:bg-slate-900 dark:group-hover:bg-accent-600 group-hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pt-8">
                {{ $books->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-surface-900 rounded-3xl border border-slate-100 dark:border-white/5 p-12 text-center max-w-2xl mx-auto shadow-sm">
                <div class="w-20 h-20 rounded-2xl bg-slate-50 dark:bg-white/5 flex items-center justify-center mx-auto mb-6 transform -rotate-6">
                    <svg class="w-10 h-10 text-slate-300 dark:text-slate-600 transform rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white">No books found</h3>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-base">We couldn't find any books matching your search criteria. Try adjusting your filters or search terms.</p>
                <div class="mt-8">
                    <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-accent-600 text-white font-semibold rounded-xl hover:bg-slate-800 dark:hover:bg-accent-700 transition-colors shadow-lg shadow-slate-900/20 dark:shadow-accent-600/20 btn-ripple">
                        Clear all filters
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
