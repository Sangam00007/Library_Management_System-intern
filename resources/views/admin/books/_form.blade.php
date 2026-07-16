<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 space-y-5">
            <h3 class="text-lg font-semibold text-white">Book Information</h3>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}" required
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Enter book title">
                @error('title')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- ISBN -->
            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-300 mb-1.5">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn ?? '') }}"
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="e.g. 978-0743273565">
                @error('isbn')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all resize-none" placeholder="Brief description of the book">{{ old('description', $book->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Row: Published Year + Language -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="published_year" class="block text-sm font-medium text-gray-300 mb-1.5">Published Year</label>
                    <input type="number" name="published_year" id="published_year" value="{{ old('published_year', $book->published_year ?? '') }}" min="1000" max="{{ date('Y') }}"
                        class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="e.g. 2024">
                    @error('published_year')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-300 mb-1.5">Language <span class="text-red-400">*</span></label>
                    <select name="language" id="language"
                        class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                        @php
                            $languages = ['English', 'Spanish', 'French', 'German', 'Chinese', 'Japanese', 'Korean', 'Hindi', 'Nepali', 'Arabic', 'Portuguese', 'Russian', 'Italian', 'Dutch', 'Other'];
                            $selectedLang = old('language', $book->language ?? 'English');
                        @endphp
                        @foreach($languages as $lang)
                            <option value="{{ $lang }}" {{ $selectedLang === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                        @endforeach
                    </select>
                    @error('language')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row: Total Copies + Available Copies -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="total_copies" class="block text-sm font-medium text-gray-300 mb-1.5">Total Copies <span class="text-red-400">*</span></label>
                    <input type="number" name="total_copies" id="total_copies" value="{{ old('total_copies', $book->total_copies ?? 1) }}" min="0" required
                        class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="0">
                    @error('total_copies')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="available_copies" class="block text-sm font-medium text-gray-300 mb-1.5">Available Copies <span class="text-red-400">*</span></label>
                    <input type="number" name="available_copies" id="available_copies" value="{{ old('available_copies', $book->available_copies ?? 1) }}" min="0" required
                        class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="0">
                    @error('available_copies')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Relationships & Image -->
    <div class="space-y-6">
        <!-- Classification -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 space-y-5">
            <h3 class="text-lg font-semibold text-white">Classification</h3>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-1.5">Category</label>
                <select name="category_id" id="category_id"
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    <option value="">— Select Category —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author -->
            <div>
                <label for="author_id" class="block text-sm font-medium text-gray-300 mb-1.5">Author</label>
                <select name="author_id" id="author_id"
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    <option value="">— Select Author —</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
                @error('author_id')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publisher -->
            <div>
                <label for="publisher_id" class="block text-sm font-medium text-gray-300 mb-1.5">Publisher</label>
                <select name="publisher_id" id="publisher_id"
                    class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                    <option value="">— Select Publisher —</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id ?? '') == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                    @endforeach
                </select>
                @error('publisher_id')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Cover Image -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 space-y-4">
            <h3 class="text-lg font-semibold text-white">Cover Image</h3>

            @if(isset($book) && $book->cover_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full max-w-[160px] mx-auto rounded-xl shadow-lg border border-gray-600/50">
                </div>
            @endif

            <div x-data="{ fileName: '' }">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-900/30 hover:bg-gray-900/50 hover:border-blue-500/50 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs text-gray-400" x-text="fileName || 'Click to upload (JPG, PNG, WebP — max 2MB)'"></p>
                    </div>
                    <input type="file" name="cover_image" class="hidden" accept="image/jpeg,image/png,image/webp" @change="fileName = $event.target.files[0]?.name">
                </label>
            </div>
            @error('cover_image')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex items-center justify-end gap-3 pt-2">
    <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 bg-gray-800 border border-gray-600 hover:bg-gray-700 text-sm font-medium text-gray-300 rounded-lg transition-colors">Cancel</a>
    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-sm font-medium text-white rounded-lg shadow-lg shadow-blue-500/30 transition-all">
        {{ isset($book) ? 'Update Book' : 'Add Book' }}
    </button>
</div>
