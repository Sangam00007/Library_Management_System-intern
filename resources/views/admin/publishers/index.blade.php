@extends('admin.layouts.app')

@section('title', 'Manage Publishers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Publishers</h1>
            <p class="text-sm text-gray-400 mt-1">Manage book publishers.</p>
        </div>
        <a href="{{ route('admin.publishers.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-sm font-medium text-white rounded-lg shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Publisher
        </a>
    </div>

    <!-- Search -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-4">
        <form method="GET" action="{{ route('admin.publishers.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-9 pr-3 py-2 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors" placeholder="Search publishers by name, address or contact number...">
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-sm font-medium text-white rounded-lg transition-colors">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.publishers.index') }}" class="px-4 py-2 bg-gray-800 border border-gray-600 hover:bg-gray-700 text-sm font-medium text-gray-300 rounded-lg transition-colors">Clear</a>
            @endif
        </form>
    </div>

    <!-- Publishers Table -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden">
        @if($publishers->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h3 class="text-sm font-medium text-gray-400">No publishers found</h3>
                <p class="text-xs text-gray-500 mt-1">Get started by adding your first publisher.</p>
                <a href="{{ route('admin.publishers.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-sm font-medium text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Publisher
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-900/50 text-gray-400 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Name</th>
                            <th scope="col" class="px-6 py-4 font-medium">Address</th>
                            <th scope="col" class="px-6 py-4 font-medium">Contact</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Total Books</th>
                            <th scope="col" class="px-6 py-4 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 text-gray-300">
                        @foreach($publishers as $publisher)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-yellow-500/20">
                                        <span class="text-white font-bold text-xs">{{ substr($publisher->name, 0, 1) }}</span>
                                    </div>
                                    <p class="font-medium text-white">{{ $publisher->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate text-gray-400" title="{{ $publisher->address }}">
                                    {{ $publisher->address ?: '—' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $publisher->contact_number ?: '—' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-700/50 text-gray-300 border border-gray-600/50 min-w-[2.5rem]">
                                    {{ $publisher->books_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.publishers.edit', $publisher) }}" class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.publishers.destroy', $publisher) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this publisher?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($publishers->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $publishers->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
