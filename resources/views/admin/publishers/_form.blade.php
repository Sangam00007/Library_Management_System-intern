<div class="space-y-6">
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 space-y-5">
        <h3 class="text-lg font-semibold text-white">Publisher Details</h3>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name <span class="text-red-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $publisher->name ?? '') }}" required
                class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="e.g. Penguin Books">
            @error('name')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-300 mb-1.5">Address</label>
            <textarea name="address" id="address" rows="3"
                class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all resize-none" placeholder="Publisher address">{{ old('address', $publisher->address ?? '') }}</textarea>
            @error('address')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contact Number -->
        <div>
            <label for="contact_number" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $publisher->contact_number ?? '') }}"
                class="block w-full px-3 py-2.5 border border-gray-600 rounded-lg bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="e.g. +1 234 567 8900">
            @error('contact_number')
                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('admin.publishers.index') }}" class="px-5 py-2.5 bg-gray-800 border border-gray-600 hover:bg-gray-700 text-sm font-medium text-gray-300 rounded-lg transition-colors">Cancel</a>
    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-sm font-medium text-white rounded-lg shadow-lg shadow-blue-500/30 transition-all">
        {{ isset($publisher) ? 'Update Publisher' : 'Add Publisher' }}
    </button>
</div>
