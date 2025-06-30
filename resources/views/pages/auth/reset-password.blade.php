@extends('layouts.auth')

@section('content')
    <div class="relative z-1 flex h-screen w-full overflow-hidden bg-white px-4 py-6 dark:bg-gray-900 sm:p-0">
        <div class="flex flex-1 flex-col rounded-2xl p-6 sm:rounded-none sm:border-0 sm:p-8">
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                <div>
                    <div class="mb-5 sm:mb-8">
                        <h1 class="mb-2 text-title-sm font-semibold text-gray-800 dark:text-white/90 sm:text-title-md">
                            Reset Password
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Enter a new password for your account.
                        </p>
                    </div>

                    {{-- Success message (mis. “Password berhasil di-reset”) --}}
                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('auth.password.update') }}" method="POST">
                        @csrf
                        {{-- token disertakan di link & dikirim ulang lewat hidden input --}}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="space-y-5">

                            {{-- Email --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email <span class="text-error-500">*</span>
                                </label>
                                <div x-data="{ hasError: {{ session('errors') && session('errors')->has('email') ? 'true' : 'false' }} }">
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $email ?? '') }}"
                                        placeholder="Your email"
                                        :class="hasError ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-700 focus:border-brand-300 dark:focus:border-brand-800'"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-none focus:ring focus:ring-brand-500/10 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        required
                                    />
                                    <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                    @error('email') * {{ $message }} @enderror
                                </span>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    New Password <span class="text-error-500">*</span>
                                </label>
                                <div x-data="{ showPassword: false, hasError: {{ session('errors') && session('errors')->has('password') ? 'true' : 'false' }} }" class="relative">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        placeholder="Enter new password"
                                        :class="hasError ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-700 focus:border-brand-300 dark:focus:border-brand-800'"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border bg-transparent py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-none focus:ring focus:ring-brand-500/10 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        required
                                    />
                                    <span
                                        @click="showPassword = !showPassword"
                                        class="absolute right-4 top-1/2 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400"
                                    >
                                    <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
                                </span>
                                    <span class="absolute text-xs font-medium text-red-500 dark:text-red-500 mt-1 left-0 min-h-[20px]" x-show="hasError">
                                    @error('password') * {{ $message }} @enderror
                                </span>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Confirm New Password <span class="text-error-500">*</span>
                                </label>
                                <div x-data="{ showPassword: false }" class="relative">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password_confirmation"
                                        placeholder="Confirm new password"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                        required
                                    />
                                    <span
                                        @click="showPassword = !showPassword"
                                        class="absolute right-4 top-1/2 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400"
                                    >
                                    <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
                                </span>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div>
                                <button
                                    type="submit"
                                    class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                                >
                                    Reset Password
                                </button>
                            </div>

                            {{-- Back to login --}}
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

        {{-- Kanan: ilustrasi/logo --}}
        <div class="relative z-1 hidden flex-1 items-center justify-center bg-brandBase p-8 dark:bg-white/5 lg:flex">
            <div class="flex max-w-xs flex-col items-center">
                <a href="/" class="mb-4 flex items-center space-x-3 text-white font-semibold text-lg">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-52 w-auto" />
                </a>
            </div>
        </div>
    </div>
@endsection
