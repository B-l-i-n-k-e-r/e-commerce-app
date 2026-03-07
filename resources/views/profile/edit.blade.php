@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 flex items-center justify-center min-h-screen py-12 px-4">
        <div class="w-full max-w-2xl">
            
            {{-- Header with Glass Card --}}
            <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                    Account <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Settings</span>
                </h2>
                <p class="text-sm font-medium light:text-gray-500 dark:text-gray-400 mt-2">Update your profile and security information</p>
            </div>

            {{-- Main Form Card --}}
            <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="p-8 md:p-10">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PATCH')

                        {{-- Profile Photo Section --}}
                        <div class="glass-card rounded-2xl p-8 border border-white/5 light:border-gray-200 text-center">
                            <div class="flex flex-col items-center">
                                <div class="relative group">
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-600 to-blue-600 blur-lg opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                                    <img
                                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_photos/default-profile.jpeg') }}"
                                        alt="Profile Photo"
                                        id="profilePhotoPreview"
                                        class="relative w-32 h-32 rounded-2xl object-cover ring-4 ring-white/20 light:ring-gray-200 shadow-2xl transition-transform group-hover:scale-105 duration-300"
                                    >
                                    <button
                                        type="button"
                                        class="absolute -bottom-2 -right-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white p-3 rounded-xl shadow-lg transition-all active:scale-90"
                                        onclick="document.getElementById('profile_photo').click();"
                                        title="Change Photo"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                                <p class="mt-4 text-[9px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">JPG, PNG or GIF (Max 2MB)</p>
                            </div>
                        </div>

                        {{-- Identity Section --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Identity</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                </div>
                            </div>
                        </div>

                        {{-- Security Section --}}
                        <div class="space-y-6 pt-6 border-t border-white/5 light:border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Security Update</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="new_password" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">New Password</label>
                                    <div class="relative">
                                        <input type="password" name="new_password" id="new_password" autocomplete="new-password"
                                            class="w-full portal-input p-4 pr-12 text-sm font-medium outline-none focus:ring-1 focus:ring-rose-600">
                                        <button type="button" onclick="togglePassword('new_password', this)" 
                                                class="absolute right-4 top-1/2 -translate-y-1/2 light:text-gray-400 dark:text-gray-500 hover:text-rose-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="new_password_confirmation" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Confirm Password</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" autocomplete="new-password"
                                        class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-rose-600">
                                </div>
                            </div>
                            <p class="text-[8px] font-medium light:text-gray-400 dark:text-gray-500 italic">Leave password fields blank to keep current password</p>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-between pt-8 border-t border-white/5 light:border-gray-200">
                            <a href="{{ route('profile.index') }}" 
                               class="group inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-widest light:text-gray-400 dark:text-gray-500 hover:text-purple-600 transition-colors">
                                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Cancel Changes
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                                <span class="flex items-center gap-2">
                                    Save Profile
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                            </button>
                        </div>

                        {{-- Error Display --}}
                        @if ($errors->any())
                            <div class="glass-card rounded-2xl p-4 border border-rose-500/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500/10 to-rose-500/10 border border-rose-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 light:text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black light:text-rose-700 dark:text-rose-400 uppercase tracking-widest">Validation Errors</p>
                                        <ul class="text-[8px] font-medium light:text-rose-600 dark:text-rose-400 list-disc list-inside mt-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base page background */
    .page-bg {
        min-height: 100vh;
        width: 100%;
    }

    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    /* Glassmorphism Logic */
    .light .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }

    .dark .glass-card {
        background: rgba(11, 17, 32, 0.9);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    }

    /* Portal Input Styles */
    .light .portal-input {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        color: #0f172a;
        transition: all 0.3s ease;
    }
    
    .light .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .light .portal-input::placeholder {
        color: #94a3b8;
    }

    .dark .portal-input {
        background: #0f172a;
        border: 1px solid #1e293b;
        border-radius: 1rem;
        color: #ffffff;
        transition: all 0.3s ease;
    }
    
    .dark .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .dark .portal-input::placeholder {
        color: #334155;
    }

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>

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
@endsection