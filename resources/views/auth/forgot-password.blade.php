<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Reset Password</h2>
        <p class="text-gray-400 text-sm leading-relaxed px-4">
            Forgot your password? No problem. Enter your email and we'll send you a reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="block text-white font-bold mb-2 text-sm">Email</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="Enter your email"
                   class="w-full bg-[#15171A] border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all placeholder-gray-600">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-[#A3050A] hover:bg-[#850408] text-white font-normal text-lg py-3 rounded-lg transition-colors shadow-lg">
            Email Password Reset Link
        </button>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-white hover:text-gray-300 text-sm font-bold">
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
