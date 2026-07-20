@extends('admin.layouts.app')

@section('title', 'Edit Author')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.authors.index') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Edit Author</h1>
            <p class="text-sm text-gray-400 mt-1">Update the details for <span class="text-white font-medium">{{ $author->name }}</span>.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.authors.update', $author) }}">
        @csrf
        @method('PUT')
        @include('admin.authors._form')
    </form>
</div>
@endsection
