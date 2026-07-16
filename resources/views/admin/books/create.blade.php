@extends('admin.layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.books.index') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Add New Book</h1>
            <p class="text-sm text-gray-400 mt-1">Fill in the details to add a new book to the catalog.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.books._form')
    </form>
</div>
@endsection
