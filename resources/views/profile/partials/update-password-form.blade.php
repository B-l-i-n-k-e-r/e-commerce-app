<x-card title="Security & Authentication" :open="false">
    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="current_password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                Current Password
            </label>
            <div class="relative group">
                <input 
                    id="current_password" 
                    name="current_password" 
                    type="password" 
                    required
                    class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-3.5 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400"
                >
                <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-bold uppercase" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-50 dark:border-gray-800">
            <div class="space-y-2">
                <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                    New Password
                </label>
                <div class="relative group">
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required
                        class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-3.5 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400"
                    >
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                    Confirm New Password
                </label>
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    required
                    class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-3.5 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all"
                >
            </div>
        </div>

        <div class="flex items-center justify-between pt-6">
            <div class="flex items-center gap-2 text-amber-600 dark:text-amber-500">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <span class="text-[10px] font-bold uppercase tracking-tight">Requires re-login</span>
            </div>
            
            <button type="submit" 
                    class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-xl transition-all active:scale-95">
                Update Security Keys
            </button>
        </div>
    </form>
</x-card>