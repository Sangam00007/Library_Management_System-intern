<div class="space-y-6">
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl p-6 space-y-5">
        <h3 class="text-lg font-semibold text-slate-900">Author Details</h3>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-600 mb-1.5">Name <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $author->name ?? '') }}" required
                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-all" placeholder="e.g. J.K. Rowling">
            @error('name')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio -->
        <div>
            <label for="bio" class="block text-sm font-medium text-slate-600 mb-1.5">Bio</label>
            <textarea name="bio" id="bio" rows="4"
                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-all resize-none" placeholder="Brief biography of this author">{{ old('bio', $author->bio ?? '') }}</textarea>
            @error('bio')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('admin.authors.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-100 text-sm font-medium text-slate-600 rounded-lg transition-colors">Cancel</a>
    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-sm font-medium text-white rounded-lg shadow-lg shadow-amber-500/30 transition-all">
        {{ isset($author) ? 'Update Author' : 'Add Author' }}
    </button>
</div>
