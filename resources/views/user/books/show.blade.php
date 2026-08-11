@extends('user.layouts.app')
@section('title', $book->title . ' - Library Management System')

@section('content')
<div class="space-y-10">

    <!-- Back Button & Breadcrumbs -->
    <div class="flex items-center gap-4 text-sm font-medium text-slate-500">
        <a href="{{ route('user.books.index') }}" class="flex items-center gap-2 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Books
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-700 truncate max-w-[200px] sm:max-w-md">{{ $book->title }}</span>
    </div>

    <!-- Main Content Area -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute -right-40 -top-40 w-96 h-96 bg-emerald-400/10 rounded-full blur-[100px]"></div>
        <div class="absolute -left-40 -bottom-40 w-96 h-96 bg-blue-400/10 rounded-full blur-[100px]"></div>

        <div class="relative z-10 p-6 sm:p-12 lg:p-16 flex flex-col lg:flex-row gap-12 lg:gap-16">
            
            <!-- Book Cover Column -->
            <div class="w-2/3 mx-auto sm:w-1/2 lg:w-1/3 flex-shrink-0">
                <div class="aspect-[2/3] bg-slate-50 rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/10 border border-slate-100 relative group">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-4">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-sm font-semibold tracking-widest uppercase">No Cover</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
            </div>

            <!-- Book Details Column -->
            <div class="flex-1 flex flex-col justify-between">
                <div class="space-y-8">
                    <!-- Title & Author -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-lg border border-emerald-100">{{ $book->category->name }}</span>
                            @if($book->available_copies > 0)
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-lg border border-blue-100 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                    Available
                                </span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-700 text-xs font-bold uppercase tracking-wider rounded-lg border border-rose-100">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $book->title }}</h1>
                        <p class="text-lg sm:text-xl font-medium text-slate-500 flex items-center gap-2">
                            <span class="text-slate-400">by</span>
                            <span class="text-slate-800">{{ $book->author->name }}</span>
                        </p>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-slate prose-lg max-w-none text-slate-600">
                        @if($book->description)
                            <p>{{ $book->description }}</p>
                        @else
                            <p class="italic text-slate-400">No description available for this book.</p>
                        @endif
                    </div>

                    <!-- Meta Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 py-6 border-y border-slate-100">
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">ISBN</p>
                            <p class="text-base font-bold text-slate-800 mt-1">{{ $book->isbn }}</p>
                        </div>
                        @if($book->publisher)
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Publisher</p>
                            <p class="text-base font-bold text-slate-800 mt-1">{{ $book->publisher->name }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Publication Year</p>
                            <p class="text-base font-bold text-slate-800 mt-1">{{ $book->publication_year ?? 'N/A' }}</p>
                        </div>
                        @if($book->language)
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Language</p>
                            <p class="text-base font-bold text-slate-800 mt-1 capitalize">{{ $book->language }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Pages</p>
                            <p class="text-base font-bold text-slate-800 mt-1">{{ $book->pages ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Available Copies</p>
                            <p class="text-base font-bold text-slate-800 mt-1">{{ $book->available_copies }} of {{ $book->total_copies }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-10 pt-8 flex items-center justify-between gap-6 border-t border-slate-100">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Want to read this book?</p>
                        <p class="text-xs text-slate-400 mt-0.5">You can borrow it if copies are available.</p>
                    </div>

                    @if($book->available_copies > 0)
                        <form action="{{ route('user.books.request', $book) }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto justify-center px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-2xl transition-all shadow-lg shadow-slate-900/20 active:scale-95 flex items-center gap-2 group">
                                <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Request to Borrow
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full sm:w-auto justify-center px-8 py-4 bg-slate-100 text-slate-400 font-semibold rounded-2xl cursor-not-allowed flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Currently Unavailable
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
