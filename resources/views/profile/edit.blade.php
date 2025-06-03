@extends('layouts.app')

@section('content')
<div class="mt-8"> {{-- Removed the container class and applied margin-top directly --}}
    <h2 class="text-3xl font-semibold text-center mb-6 text-gray-800">Edit Profile</h2>

    <div class="row justify-content-center"> {{-- This class centers the column horizontally --}}
        <div class="col-lg-8" style="max-width: 700px;"> {{-- Reduced width --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Photo Section --}}
                    <div class="text-center mb-6">
                        <img
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_photos/default-profile.jpeg'); }}"
                            alt="Profile Photo"
                            id="profilePhotoPreview"
                            width="150"
                            height="150"
                            class="rounded-circle mb-2 inline-block"
                        >
                        <button
                            type="button"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded inline-block ml-2"
                            onclick="document.getElementById('profile_photo').click();"
                        >
                            Change Profile Photo
                        </button>
                        <input
                            type="file"
                            name="profile_photo"
                            id="profile_photo"
                            class="hidden"
                            accept="image/*"
                            onchange="previewPhoto(event)"
                        >
                    </div>

                    {{-- Personal Info --}}
                    <fieldset>
                        <legend class="text-lg font-semibold mb-4 text-gray-700">Personal Information</legend>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                        </div>
                    </fieldset>

                    {{-- Password Update --}}
                    <fieldset class="mt-6">
                        <legend class="text-lg font-semibold mb-4 text-gray-700">Change Password</legend>

                        <div class="mb-4 relative">
                            <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password:</label>
                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700"
                                autocomplete="new-password"
                            >
                            <span
                                class="absolute right-3 top-[38px] cursor-pointer text-gray-500"
                                onclick="togglePassword('new_password', this)"
                            >👁️</span>
                        </div>

                        <div class="mb-4 relative">
                            <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password:</label>
                            <input
                                type="password"
                                name="new_password_confirmation"
                                id="new_password_confirmation"
                                class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700"
                                autocomplete="new-password"
                            >
                            <span
                                class="absolute right-3 top-[38px] cursor-pointer text-gray-500"
                                onclick="togglePassword('new_password_confirmation', this)"
                            >👁️</span>
                        </div>
                    </fieldset>

                    {{-- Action Buttons --}}
                    <div class="flex justify-between mt-6">
                        <button
                            type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
                        >
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <a
                            href="{{ route('profile.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
                        >
                            <i class="fas fa-times-circle"></i> Cancel
                        </a>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-6" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </span>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        main {
            display: flex;
            justify-content: center; /* Ensure horizontal centering of direct children */
            align-items: center;
            min-height: calc(100vh - /* Adjust this value based on your navigation bar's height */ );
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .min-h-screen {
            display: flex;
            flex-direction: column;
        }
        main {
            flex-grow: 1;
        }
    </style>
@endpush

@push('scripts')
<script>
    function previewPhoto(event) {
        const photoPreview = document.getElementById('profilePhotoPreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            photoPreview.src = "{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}";
        }
    }

    function togglePassword(inputId, iconElement) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        iconElement.textContent = isPassword ? '🙈' : '👁️';
    }
</script>
@endpush