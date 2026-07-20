@extends('admin.layouts.app')

@section('title', 'Add Publisher')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.publishers.index') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Add Publisher</h1>
            <p class="text-sm text-gray-400 mt-1">Create a new publisher for your library's books.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.publishers.store') }}">
        @csrf
        @include('admin.publishers._form')
    </form>
</div>
@endsection
