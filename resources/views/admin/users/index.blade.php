@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-7xl mx-auto mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                    {{ __('User Management') }}
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Review permissions, verify identities, and manage platform access.
                </p>
            </div>
            
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-widest py-3 px-6 rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                {{ __('Create New User') }}
            </a>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="max-w-7xl mx-auto mb-6 flex items-center p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl">
                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="ml-3 text-sm font-bold text-green-800 dark:text-green-400 uppercase tracking-tight">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest w-px whitespace-nowrap">ID</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">User Identity</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Verification</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Access Level</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest w-px whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-5 text-sm font-bold text-gray-400 dark:text-gray-600 tabular-nums">
                                    #{{ $user->id }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $user->name }}</span>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-500">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($user->email_verified_at)
                                        <div class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                            Verified
                                        </div>
                                    @else
                                        <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-500 underline decoration-2 underline-offset-4">
                                                Manual Verify
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex gap-2">
                                        @if ($user->is_admin)
                                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800">
                                                Administrator
                                            </span>
                                        @else
                                            <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-purple-600 transition-colors">
                                                    Elevate to Admin
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.users.toggleManager', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $user->is_manager ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' }}">
                                                    {{ $user->is_manager ? 'Manager' : 'Grant Manager' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Purge this user profile permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-200 dark:text-gray-800 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No personnel records found.</p>
                                    </div>
                                </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-8">
            {{ $users->links() }}
        </div>
    </div>
@endsection