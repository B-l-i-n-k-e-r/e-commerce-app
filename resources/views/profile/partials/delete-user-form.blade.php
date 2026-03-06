<section class="mt-12 pt-8 border-t border-red-100 dark:border-red-900/30">
    <header class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-xl">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
                {{ __('Danger Zone') }}
            </h2>
        </div>

        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently purged. This action is irreversible. Please download any data you wish to retain before proceeding.') }}
        </p>
    </header>

    <button 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500 text-white text-xs font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-red-500/20 transition-all active:scale-95"
    >
        {{ __('Delete Permanent Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white dark:bg-gray-950 rounded-3xl">
            @csrf
            @method('delete')

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-full mb-4">
                    <svg class="w-10 h-10 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                    {{ __('Confirm Deletion') }}
                </h2>
                <p class="mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 leading-relaxed px-4">
                    {{ __('To verify this destructive action, please enter your password below. All data associated with this profile will be removed from our servers immediately.') }}
                </p>
            </div>

            <div class="space-y-2 max-w-sm mx-auto">
                <label for="password" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ __('Security Verification') }}</label>
                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl py-4 px-5 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 transition-all placeholder-gray-400"
                    placeholder="{{ __('Your Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs font-bold uppercase tracking-tight" />
            </div>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="w-full sm:w-auto px-8 py-4 text-xs font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-colors uppercase tracking-widest"
                >
                    {{ __('I changed my mind') }}
                </button>

                <button 
                    type="submit"
                    class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-lg shadow-red-500/20 transition-all active:scale-95"
                >
                    {{ __('Permanently Delete') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>