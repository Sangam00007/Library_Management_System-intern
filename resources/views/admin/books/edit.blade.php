@extends('admin.layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.books.index') }}" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Book</h1>
            <p class="text-sm text-slate-500 mt-1">Update the details for <span class="text-slate-900 font-medium">{{ $book->title }}</span>.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.books._form')
    </form>
</div>
@endsection
