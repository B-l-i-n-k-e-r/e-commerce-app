@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex justify-center items-center">
        <div class="w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4 pt-4">
                <h2 class="h3 mb-0 text-blue-400">Edit User</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to User List
                </a>
            </div>

            <div class="card shadow-md rounded-lg mb-8 bg-gray-800">
                <div class="card-body flex justify-center items-center">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6 w-full max-w-md">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input id="name" type="text" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 focus:ring-red-500 @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                            <input id="email" type="email" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 focus:ring-red-500 @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password (Leave blank to keep current)</label>
                            <input id="password" type="password" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 focus:ring-red-500 @enderror" name="password" autocomplete="new-password">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                            <input id="password-confirm" type="password" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm" name="password_confirmation" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
