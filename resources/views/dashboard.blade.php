<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Account Overview') }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-px whitespace-nowrap">
                                        {{ __('Description') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-px whitespace-nowrap">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-px whitespace-nowrap">
                                        {{ __('Amount (Ksh)') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm">
                                        {{ __('Service Fee') }}
                                    </td>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm text-green-500">
                                        {{ __('Paid') }}
                                    </td>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm text-right font-mono">
                                        Ksh 1,500.00
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm">
                                        {{ __('Current Balance') }}
                                    </td>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm text-blue-500">
                                        {{ __('Pending') }}
                                    </td>
                                    <td class="px-6 py-4 w-px whitespace-nowrap text-sm text-right font-mono">
                                        Ksh 12,450.75
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>