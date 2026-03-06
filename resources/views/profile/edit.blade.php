@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen py-12">
    <div class="w-full max-w-2xl px-4">
        
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
                Account Settings
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Update your profile and security information</p>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-300">
            <div class="p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-col items-center justify-center p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div class="relative group">
                            <img
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_photos/default-profile.jpeg') }}"
                                alt="Profile Photo"
                                id="profilePhotoPreview"
                                class="w-32 h-32 rounded-2xl object-cover ring-4 ring-white dark:ring-gray-900 shadow-xl transition-transform group-hover:scale-105 duration-300"
                            >
                            <button
                                type="button"
                                class="absolute -bottom-2 -right-2 bg-blue-600 hover:bg-blue-500 text-white p-2 rounded-xl shadow-lg transition-all active:scale-90"
                                onclick="document.getElementById('profile_photo').click();"
                                title="Change Photo"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                        <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                        <p class="mt-4 text-xs font-bold text-gray-400 uppercase tracking-widest">JPG, PNG or GIF (Max 2MB)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <h3 class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-4">Identity</h3>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="name" class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase ml-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl py-3 px-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase ml-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl py-3 px-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-black text-red-600 dark:text-red-400 uppercase tracking-widest mb-6">Security Update</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2 relative">
                                <label for="new_password" class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase ml-1">New Password</label>
                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password" autocomplete="new-password"
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl py-3 px-4 pr-12 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 transition-all">
                                    <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="new_password_confirmation" class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase ml-1">Confirm Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" autocomplete="new-password"
                                    class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl py-3 px-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-8">
                        <a href="{{ route('profile.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors uppercase tracking-widest">
                            Cancel Changes
                        </a>
                        <button type="submit" class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-500 text-white font-black py-4 px-8 rounded-2xl shadow-xl transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Save Profile
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 p-4 rounded-2xl mt-6">
                            <ul class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-tight list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewPhoto(event) {
        const photoPreview = document.getElementById('profilePhotoPreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => photoPreview.src = e.target.result;
            reader.readAsDataURL(file);
        }
    }

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        
        // Dynamic SVG swap
        btn.innerHTML = isPassword 
            ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>`
            : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
    }
</script>
@endpush