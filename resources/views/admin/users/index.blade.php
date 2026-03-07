@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full page-bg relative overflow-hidden">
        <!-- Full-window background elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            
            {{-- Header with Glass Card --}}
            <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="light:text-purple-600 dark:text-blue-400">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                                {{ __('User Management') }}
                            </h2>
                            <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">
                                Review permissions, verify identities, and manage platform access.
                            </p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center justify-center bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Create New User') }}
                    </a>
                </div>
            </div>

            {{-- Success Toast --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="max-w-7xl mx-auto mb-6 glass-card rounded-2xl p-4 border border-green-500/20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 uppercase tracking-widest">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Users Table with Glass Card --}}
            <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 light:border-gray-200">
                                <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] w-px whitespace-nowrap">ID</th>
                                <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">User Name</th>
                                <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Verification Status</th>
                                <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Role</th>
                                <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] w-px whitespace-nowrap text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 light:divide-gray-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-5">
                                        <span class="text-xs font-black light:text-gray-400 dark:text-gray-500 tabular-nums">
                                            #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-sm shadow-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-tight">{{ $user->name }}</span>
                                                <span class="text-xs font-medium light:text-gray-500 dark:text-gray-500">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if ($user->email_verified_at)
                                            <div class="inline-flex items-center px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-green-500/10 to-emerald-500/10 light:from-green-500/5 light:to-emerald-500/5 border border-green-500/20 light:text-green-700 dark:text-green-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                                Verified
                                            </div>
                                        @else
                                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-[9px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-500 underline decoration-2 underline-offset-4 transition-colors">
                                                    Manual Verify
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-wrap gap-2">
                                            @if ($user->is_admin)
                                                <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-purple-500/10 light:from-purple-500/5 light:to-purple-500/5 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                                    Administrator
                                                </span>
                                            @else
                                                <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-[9px] font-black uppercase tracking-widest light:text-gray-400 dark:text-gray-500 hover:text-purple-600 transition-colors">
                                                        Make Admin
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('admin.users.toggleManager', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all {{ $user->is_manager 
                                                        ? 'bg-gradient-to-r from-amber-500/10 to-amber-500/10 border border-amber-500/20 light:text-amber-700 dark:text-amber-400' 
                                                        : 'light:bg-gray-100 dark:bg-white/5 light:text-gray-500 dark:text-gray-400 hover:bg-amber-500/10' }}">
                                                        {{ $user->is_manager ? 'Manager' : 'Upgrade To Manager' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-purple-600 hover:bg-purple-500/10 light:hover:bg-purple-50 rounded-xl transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Purge this user profile permanently?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-red-600 hover:bg-red-500/10 light:hover:bg-red-50 rounded-xl transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            </div>
                                            <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No personnel records found.</p>
                                            <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">Create your first user to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <style>
        /* Base page background logic */
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

        /* Light mode gradient colors - Purple & Blue theme */
        .light .from-purple-100 { --tw-gradient-from: #f3e8ff; }
        .light .to-blue-100 { --tw-gradient-to: #dbeafe; }
        .light .from-purple-500 { --tw-gradient-from: #a855f7; }
        .light .to-blue-500 { --tw-gradient-to: #3b82f6; }
        .light .from-purple-600 { --tw-gradient-from: #9333ea; }
        .light .to-blue-600 { --tw-gradient-to: #2563eb; }
        .light .from-purple-500\/5 { --tw-gradient-from: rgba(168, 85, 247, 0.05); }
        .light .to-blue-500\/5 { --tw-gradient-to: rgba(59, 130, 246, 0.05); }
        .light .from-green-500\/5 { --tw-gradient-from: rgba(34, 197, 94, 0.05); }
        .light .to-emerald-500\/5 { --tw-gradient-to: rgba(16, 185, 129, 0.05); }
        .light .from-amber-500\/5 { --tw-gradient-from: rgba(245, 158, 11, 0.05); }
        .light .to-amber-500\/5 { --tw-gradient-to: rgba(245, 158, 11, 0.05); }

        /* Light mode text colors */
        .light .text-purple-700 { color: #7e22ce; }
        .light .text-green-700 { color: #15803d; }
        .light .text-amber-700 { color: #b45309; }

        /* Dark mode text colors */
        .dark .text-purple-400 { color: #c084fc; }
        .dark .text-green-400 { color: #4ade80; }
        .dark .text-amber-400 { color: #fbbf24; }

        /* Pagination styling */
        nav[role="navigation"] {
            @apply flex items-center justify-between;
        }
        
        nav[role="navigation"] a, 
        nav[role="navigation"] span {
            @apply px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all;
        }
        
        nav[role="navigation"] a:hover {
            @apply bg-purple-500/10 text-purple-600;
        }
        
        nav[role="navigation"] span[aria-current="page"] span {
            @apply bg-gradient-to-r from-purple-600 to-blue-600 text-white;
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
        }
    </style>
@endsection