<div class="space-y-6">
    <div class="bg-white backdrop-blur-sm border border-slate-200 rounded-2xl p-6 space-y-5">
        <h3 class="text-lg font-semibold text-slate-900">Category Details</h3>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-600 mb-1.5">Name <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required
                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-all" placeholder="e.g. Science Fiction">
            @error('name')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-slate-600 mb-1.5">Description</label>
            <textarea name="description" id="description" rows="4"
                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm transition-all resize-none" placeholder="Brief description of this category">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category Image -->
        <div x-data="{
            imagePreview: '{{ isset($category) && $category->image ? asset('storage/' . $category->image) : '' }}',
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.imagePreview = e.target.result;
                    reader.readAsDataURL(file);
                }
            },
            removeImage() {
                this.imagePreview = '';
                document.getElementById('image').value = '';
            }
        }">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Category Image</label>

            <!-- Preview -->
            <div x-show="imagePreview" class="mb-3" style="display: none;">
                <div class="relative inline-block group">
                    <img :src="imagePreview" alt="Category preview" class="w-32 h-32 object-cover rounded-xl border border-slate-200 shadow-sm">
                    <button type="button" @click="removeImage()" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Upload Area -->
            <label for="image" class="relative flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-amber-400 transition-all group" x-show="!imagePreview">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 text-slate-400 group-hover:text-amber-500 transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-sm text-slate-500"><span class="font-semibold text-amber-600">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-slate-400 mt-1">PNG, JPG, GIF or WebP (Max 2MB)</p>
                </div>
            </label>

            <!-- Change button when preview is showing -->
            <div x-show="imagePreview" style="display: none;">
                <label for="image" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-amber-600 bg-amber-50 rounded-lg cursor-pointer hover:bg-amber-100 transition-colors mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Change Image
                </label>
            </div>

            <input id="image" name="image" type="file" class="hidden" accept="image/*" @change="handleFileSelect($event)">

            @error('image')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-100 text-sm font-medium text-slate-600 rounded-lg transition-colors">Cancel</a>
    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-sm font-medium text-white rounded-lg shadow-lg shadow-amber-500/30 transition-all">
        {{ isset($category) ? 'Update Category' : 'Add Category' }}
    </button>
</div>
