<x-card title="Notification Channels" :open="false">
    <form method="POST" action="{{ route('profile.update.notifications') }}" class="space-y-8">
        @csrf
        @method('PATCH')

        <div class="space-y-6">
            <div class="flex items-center justify-between group">
                <div class="flex flex-col">
                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">
                        Email Notifications
                    </span>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">
                        Receive order updates and monthly reports via email.
                    </span>
                </div>
                
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="email_notifications" class="sr-only peer" 
                           {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 rounded-full"></div>
                </label>
            </div>

            <div class="h-px bg-gray-100 dark:bg-gray-800"></div>

            <div class="flex items-center justify-between group">
                <div class="flex flex-col">
                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">
                        SMS Notifications
                    </span>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">
                        Get instant alerts for security and delivery status.
                    </span>
                </div>
                
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="sms_notifications" class="sr-only peer" 
                           {{ auth()->user()->sms_notifications ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 rounded-full"></div>
                </label>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" 
                    class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95">
                Save Preferences
            </button>
        </div>
    </form>
</x-card>