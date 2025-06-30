@extends('layouts.auth')

@section('content')
    <div class="relative z-1 flex h-screen w-full overflow-hidden bg-white px-4 py-6 dark:bg-gray-900 sm:p-0">
        <div class="flex flex-1 flex-col rounded-2xl p-6 sm:rounded-none sm:border-0 sm:p-8">
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                <div>
                    <div class="mb-5 sm:mb-8">
                        <h1 class="mb-2 text-title-sm font-semibold text-gray-800 dark:text-white/90 sm:text-title-md">
                            Forgot Password
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Enter your email and we'll send you a link to reset your password.
                        </p>
                    </div>
                    <div>
                        @if (session('status'))
                            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('auth.password.email') }}" method="POST">
                            @csrf
                            <div class="space-y-5">
                                <!-- Email -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email <span class="text-error-500">*</span>
                                    </label>
                                    <div x-data="{ hasError: {{ session('errors') && session('errors')->has('email') ? 'true' : 'false' }} }">
                                        <input
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="Enter your email"
                                            :class="hasError ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-700 focus:border-brand-300 dark:focus:border-brand-800'"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-none focus:ring focus:ring-brand-500/10 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                            required
                                        />
                                        <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                        @error('email') * {{ $message }} @enderror
                                    </span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button
                                        type="submit"
                                        class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                                    >
                                        Send Reset Link
                                    </button>
                                </div>

                                <!-- Back to login -->
                                <div class="text-center mt-4">
                                    <a href="{{ route('auth.login') }}" class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">
                                        Back to login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="relative z-1 hidden flex-1 items-center justify-center bg-brandBase p-8 dark:bg-white/5 lg:flex">
            <div class="flex max-w-xs flex-col items-center">
                <a href="/" class="mb-4 flex items-center space-x-3 text-white font-semibold text-lg">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-52 w-auto" />
                </a>
            </div>
        </div>
    </div>
@endsection
