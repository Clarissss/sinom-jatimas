@extends('layouts.app')

@section('title', 'Login - PT. Sinom Jati Mas')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header with gradient --}}
            <div class="bg-gradient-to-r from-primary-600 to-secondary-500 px-8 py-6">
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-building text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Selamat Datang</h2>
                    <p class="text-primary-100 mt-1">Portal PT. Sinom Jati Mas</p>
                </div>
            </div>
            
            {{-- Form --}}
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   required 
                                   autocomplete="email"
                                   aria-required="true"
                                   aria-describedby="email-error"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   value="{{ old('email') }}" 
                                   placeholder="nama@perusahaan.com">
                        </div>
                        @error('email')
                            <p id="email-error" class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" 
                                   name="password" 
                                   :type="show ? 'text' : 'password'" 
                                   required
                                   autocomplete="current-password"
                                   aria-required="true"
                                   aria-describedby="password-error"
                                   class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="••••••••">
                            <button type="button" 
                                    @click="show = !show" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                    :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                <i x-show="!show" class="fa-regular fa-eye"></i>
                                <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-error" class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                                Ingat saya
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            :disabled="loading"
                            :class="{ 'opacity-75 cursor-not-allowed': loading }"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                        <span x-text="loading ? 'Memproses...' : 'Masuk'"></span>
                    </button>
                </form>

                {{-- Register Link --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors">
                            Daftar sebagai Klien
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Footer Info --}}
        <p class="mt-6 text-center text-xs text-gray-500">
            © {{ date('Y') }} PT. Sinom Jati Mas. Seluruh hak cipta dilindungi.
        </p>
    </div>
</div>
@endsection
