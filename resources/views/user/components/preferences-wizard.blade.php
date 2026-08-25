@if(!Auth::user()->wizard_completed && !empty($wizardData))
    <div x-data="{
        step: 1,
        categories: [],
        authors: [],
        publishers: [],
        loading: false,
        searchCategory: '',
        searchAuthor: '',
        searchPublisher: '',
        toggle(type, id) {
            let index = this[type].indexOf(id);
            if (index > -1) {
                this[type].splice(index, 1);
            } else {
                this[type].push(id);
            }
        },
        nextStep() {
            if (this.step < 3) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        submit() {
            this.loading = true;
            $refs.wizardForm.submit();
        }
    }"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    >
        <div 
            class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden relative"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        >
            {{-- Decorative background blurs --}}
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[80px] pointer-events-none"></div>
            <div class="absolute top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-blue-400/10 blur-[80px] pointer-events-none"></div>

            <form x-ref="wizardForm" action="{{ route('user.preferences.save') }}" method="POST" class="flex flex-col h-full z-10 relative">
                @csrf
                
                {{-- Hidden inputs synced with Alpine arrays --}}
                <template x-for="cat in categories" :key="'cat-'+cat">
                    <input type="hidden" name="categories[]" :value="cat">
                </template>
                <template x-for="auth in authors" :key="'auth-'+auth">
                    <input type="hidden" name="authors[]" :value="auth">
                </template>
                <template x-for="pub in publishers" :key="'pub-'+pub">
                    <input type="hidden" name="publishers[]" :value="pub">
                </template>

                {{-- Header --}}
                <div class="px-8 py-6 border-b border-slate-100 bg-white/50 backdrop-blur-md flex-shrink-0">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-blue-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Personalize Your Experience</h2>
                            <p class="text-sm text-slate-500 mt-0.5">Tell us what you like so we can recommend the best books for you.</p>
                        </div>
                    </div>
                    
                    {{-- Step Indicators --}}
                    <div class="mt-5 flex items-center gap-3">
                        <template x-for="s in 3" :key="s">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="flex items-center gap-2 flex-1">
                                    <div 
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 flex-shrink-0"
                                        :class="step >= s ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/30' : 'bg-slate-100 text-slate-400'"
                                    >
                                        <span x-show="step <= s" x-text="s"></span>
                                        <svg x-show="step > s" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span 
                                        class="text-xs font-semibold hidden sm:inline transition-colors"
                                        :class="step >= s ? 'text-slate-700' : 'text-slate-400'"
                                        x-text="s === 1 ? 'Categories' : (s === 2 ? 'Authors' : 'Publishers')"
                                    ></span>
                                </div>
                                <div x-show="s < 3" class="h-px flex-1 transition-colors duration-300" :class="step > s ? 'bg-emerald-300' : 'bg-slate-200'"></div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Content Area --}}
                <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                    
                    {{-- Step 1: Categories --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Pick Your Favorite Categories
                            </h3>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg" x-text="categories.length + ' selected'"></span>
                        </div>
                        
                        {{-- Search --}}
                        <div class="relative mb-5">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchCategory" placeholder="Search categories..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all">
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($wizardData['categories'] as $category)
                                <div x-show="!searchCategory || '{{ strtolower($category->name) }}'.includes(searchCategory.toLowerCase())">
                                    <div 
                                        class="p-4 rounded-2xl border-2 transition-all duration-200 flex flex-col items-center justify-center text-center h-24 relative overflow-hidden cursor-pointer select-none"
                                        :class="categories.includes({{ $category->id }}) ? 'border-emerald-500 bg-emerald-50 text-emerald-700 shadow-md shadow-emerald-500/10 scale-[1.02]' : 'border-slate-100 bg-white text-slate-600 hover:border-emerald-200 hover:bg-emerald-50/50'"
                                        @click="toggle('categories', {{ $category->id }})"
                                    >
                                        <div x-show="categories.includes({{ $category->id }})" x-transition.scale class="absolute top-2 right-2">
                                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <span class="font-semibold text-sm">{{ $category->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Step 2: Authors --}}
                    <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pick Your Favorite Authors
                            </h3>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg" x-text="authors.length + ' selected'"></span>
                        </div>

                        {{-- Search --}}
                        <div class="relative mb-5">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchAuthor" placeholder="Search authors..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($wizardData['authors'] as $author)
                                <div x-show="!searchAuthor || '{{ strtolower(addslashes($author->name)) }}'.includes(searchAuthor.toLowerCase())">
                                    <div 
                                        class="px-4 py-3 rounded-xl border-2 transition-all duration-200 flex items-center justify-between cursor-pointer select-none"
                                        :class="authors.includes({{ $author->id }}) ? 'border-blue-500 bg-blue-50 text-blue-700 shadow-sm scale-[1.02]' : 'border-slate-100 bg-white text-slate-600 hover:border-blue-200 hover:bg-blue-50/50'"
                                        @click="toggle('authors', {{ $author->id }})"
                                    >
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold"
                                                :class="authors.includes({{ $author->id }}) ? 'bg-blue-200 text-blue-700' : 'bg-slate-100 text-slate-500'"
                                            >{{ substr($author->name, 0, 1) }}</div>
                                            <span class="font-semibold text-sm truncate">{{ $author->name }}</span>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all" :class="authors.includes({{ $author->id }}) ? 'border-blue-500 bg-blue-500' : 'border-slate-300'">
                                            <svg x-show="authors.includes({{ $author->id }})" x-transition.scale class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Step 3: Publishers --}}
                    <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Pick Your Favorite Publishers
                            </h3>
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg" x-text="publishers.length + ' selected'"></span>
                        </div>

                        {{-- Search --}}
                        <div class="relative mb-5">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchPublisher" placeholder="Search publishers..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all">
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($wizardData['publishers'] as $publisher)
                                <div x-show="!searchPublisher || '{{ strtolower(addslashes($publisher->name)) }}'.includes(searchPublisher.toLowerCase())">
                                    <div 
                                        class="px-4 py-3 rounded-xl border-2 transition-all duration-200 flex items-center justify-between cursor-pointer select-none"
                                        :class="publishers.includes({{ $publisher->id }}) ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-sm scale-[1.02]' : 'border-slate-100 bg-white text-slate-600 hover:border-amber-200 hover:bg-amber-50/50'"
                                        @click="toggle('publishers', {{ $publisher->id }})"
                                    >
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold"
                                                :class="publishers.includes({{ $publisher->id }}) ? 'bg-amber-200 text-amber-700' : 'bg-slate-100 text-slate-500'"
                                            >{{ substr($publisher->name, 0, 1) }}</div>
                                            <span class="font-semibold text-sm truncate">{{ $publisher->name }}</span>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all" :class="publishers.includes({{ $publisher->id }}) ? 'border-amber-500 bg-amber-500' : 'border-slate-300'">
                                            <svg x-show="publishers.includes({{ $publisher->id }})" x-transition.scale class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Footer / Actions --}}
                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/80 backdrop-blur-sm flex items-center justify-between rounded-b-3xl flex-shrink-0">
                    <button type="button" @click="prevStep()" x-show="step > 1" x-transition.opacity class="px-5 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-white border border-slate-200 shadow-sm transition-all hover:-translate-y-0.5 text-sm">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Back
                        </span>
                    </button>
                    <div x-show="step === 1"></div> {{-- Spacer for first step --}}

                    <button type="button" @click="nextStep()" x-show="step < 3" class="px-6 py-2.5 rounded-xl font-semibold text-white bg-slate-900 shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition-all hover:-translate-y-0.5 flex items-center gap-2 text-sm">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    
                    <button type="button" @click="submit()" x-show="step === 3" :disabled="loading" class="px-6 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 shadow-lg shadow-emerald-500/30 hover:from-emerald-600 hover:to-emerald-700 transition-all hover:-translate-y-0.5 flex items-center gap-2 text-sm disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!loading" class="flex items-center gap-2">
                            Finish Setup
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
@endif
