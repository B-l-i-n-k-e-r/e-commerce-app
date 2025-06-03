@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <div class="mb-6">
                        <div class="profile-photo-container mx-auto mb-4">
                            <img src="{{ $user->profile_photo_url }}"
                                 alt="Profile Photo"
                                 width="150"
                                 height="150"
                                 class="rounded-circle border-3 border-white shadow-md">
                        </div>

                        <h2 class="text-3xl font-semibold mb-2 text-blue-800">
                            {{ $user->name }}
                        </h2>
                        <p class="text-yellow-200 text-lg">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('profile.edit') }}"
                           class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-200">
                            Edit Profile
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - /* Adjust this value based on your navigation bar's height */ );
        }
    </style>
@endpush

<style>
    .profile-photo-container {
        position: relative;
        display: inline-flex;
    }

    .border-3 {
        border-width: 3px;
    }

    .border-white {
        border-color: white;
    }

    .shadow-lg {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .rounded-circle {
        border-radius: 50%;
    }

    .text-3xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .text-blue-800 {
        --tw-text-opacity: 1;
        color: rgba(30, 58, 138, var(--tw-text-opacity));
    }

    .text-yellow-200 {
        --tw-text-opacity: 1;
        color: rgba(254, 240, 138, var(--tw-text-opacity));
    }

    .bg-blue-500 {
        --tw-bg-opacity: 1;
        background-color: rgba(59, 130, 246, var(--tw-bg-opacity));
    }

    .hover\:bg-blue-600:hover {
        --tw-bg-opacity: 1;
        background-color: rgba(48, 100, 230, var(--tw-bg-opacity));
    }

    .text-white {
        --tw-text-opacity: 1;
        color: #fff;
    }

    .font-semibold {
        font-weight: 600;
    }

    .py-2\.5 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .px-5 {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .focus\:outline-none:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }

    .focus\:ring-2:focus {
        --tw-ring-inset: var(--tw-empty, /*!*/);
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgba(59, 130, 246, var(--tw-ring-opacity));
        --tw-ring-offset-shadow: 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        --tw-ring-shadow: 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), 0 0 0 var(--tw-shadow-sm);
    }

    .focus\:ring-opacity-50:focus {
        --tw-ring-opacity: 0.5;
    }

    .transition-colors {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-duration: 150ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    .duration-200 {
        transition-duration: 200ms;
    }
</style>