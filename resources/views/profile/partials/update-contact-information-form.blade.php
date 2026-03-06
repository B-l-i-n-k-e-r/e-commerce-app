<x-card title="Contact Information" :open="true">
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="name" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                    Full Name
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        value="{{ old('name', auth()->user()->name) }}" 
                        required
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-3.5 pl-11 pr-4 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400"
                        placeholder="John Doe"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                    Email Address
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email', auth()->user()->email) }}" 
                        required
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-3.5 pl-11 pr-4 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400"
                        placeholder="john@example.com"
                    >
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
            <p class="text-[10px] font-medium text-gray-400 italic">
                Changes are reflected immediately across all sessions.
            </p>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-3 px-8 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                Update Identity
            </button>
        </div>
    </form>
</x-card>