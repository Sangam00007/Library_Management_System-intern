@extends('user.layouts.app')

@section('title', 'My Profile | Library Management System')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 md:space-y-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">My Profile</h1>
            <p class="text-slate-500 mt-1">Manage your account settings and preferences.</p>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-medium text-sm">Profile information updated successfully.</p>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-medium text-sm">Password updated successfully.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
        <!-- Profile Information Section -->
        <div class="md:col-span-1">
            <div class="sticky top-28">
                <h2 class="text-xl font-bold text-slate-800">Profile Information</h2>
                <p class="text-sm text-slate-500 mt-2">Update your account's profile information and email address.</p>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="glass-card bg-white/80 rounded-2xl shadow-sm border border-slate-200/60 p-6 sm:p-8">
                <form method="post" action="{{ route('user.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" required autofocus autocomplete="name" />
                            @error('name')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('email') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" required autocomplete="username" />
                            @error('email')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact -->
                        <div>
                            <label for="contact" class="block text-sm font-medium text-slate-700 mb-1">Contact Number</label>
                            <input type="text" name="contact" id="contact" value="{{ old('contact', $user->contact) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('contact') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" autocomplete="tel" />
                            @error('contact')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-slate-700 mb-1">Address / Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('location') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" autocomplete="address-line1" />
                            @error('location')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/20 transition-all shadow-sm shadow-emerald-600/20 active:scale-[0.98]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="h-px bg-slate-200/60 my-8 md:my-10"></div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 pb-12">
        <!-- Update Password Section -->
        <div class="md:col-span-1">
            <div class="sticky top-28">
                <h2 class="text-xl font-bold text-slate-800">Update Password</h2>
                <p class="text-sm text-slate-500 mt-2">Ensure your account is using a long, random password to stay secure.</p>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="glass-card bg-white/80 rounded-2xl shadow-sm border border-slate-200/60 p-6 sm:p-8">
                <form method="post" action="{{ route('user.password.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="update_password_current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="update_password_current_password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('current_password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" autocomplete="current-password" />
                            @error('current_password')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                            <input type="password" name="password" id="update_password_password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" autocomplete="new-password" />
                            @error('password')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white/50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm @error('password_confirmation') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror" autocomplete="new-password" />
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-900 focus:ring-4 focus:ring-slate-500/20 transition-all shadow-sm shadow-slate-800/20 active:scale-[0.98]">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
