@guest
<div id="registerModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity opacity-0" id="registerModalBackdrop"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-[#1C1E21] border border-white/10 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="registerModalPanel">
            
            <!-- Close Button -->
            <div class="absolute right-0 top-0 pr-4 pt-4">
                <button type="button" class="rounded-md bg-transparent text-gray-400 hover:text-white focus:outline-none" onclick="closeRegisterModal()">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 sm:px-10">
                <div class="text-center mb-8">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-primary)]/10 mb-4">
                        <svg class="h-8 w-8 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold leading-6 text-white" id="modal-title">Create Account</h3>
                    <p class="mt-2 text-sm text-gray-400">Join Valen Grading today</p>
                </div>

                <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="reg_name" class="block text-sm font-medium leading-6 text-gray-300">Full Name</label>
                        <div class="mt-1">
                            <input id="reg_name" name="name" type="text" autocomplete="name" required 
                                class="w-full bg-[#15171A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all placeholder-gray-600">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="reg_email" class="block text-sm font-medium leading-6 text-gray-300">Email address</label>
                        <div class="mt-1">
                            <input id="reg_email" name="email" type="email" autocomplete="email" required 
                                class="w-full bg-[#15171A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all placeholder-gray-600">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="reg_password" class="block text-sm font-medium leading-6 text-gray-300">Password</label>
                        <div class="mt-1">
                            <input id="reg_password" name="password" type="password" autocomplete="new-password" required 
                                class="w-full bg-[#15171A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all placeholder-gray-600">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="reg_password_confirmation" class="block text-sm font-medium leading-6 text-gray-300">Confirm Password</label>
                        <div class="mt-1">
                            <input id="reg_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                class="w-full bg-[#15171A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all placeholder-gray-600">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="registerBtn" class="flex w-full justify-center rounded-xl bg-[var(--color-primary)] px-3 py-3 text-sm font-bold leading-6 text-white shadow-sm hover:bg-[var(--color-primary-hover)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-primary)] transition-all duration-300 transform hover:scale-[1.02]">
                            Register
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-400">
                        Already have an account?
                        <button type="button" onclick="switchToLogin()" class="font-semibold text-[var(--color-primary)] hover:text-red-400">Sign in</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openRegisterModal() {
        const modal = document.getElementById('registerModal');
        const backdrop = document.getElementById('registerModalBackdrop');
        const panel = document.getElementById('registerModalPanel');
        
        // Ensure Login Modal is closed
        const loginModal = document.getElementById('loginModal');
        if (!loginModal.classList.contains('hidden')) {
            closeLoginModal();
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Lock scroll
        
        // Animation
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 10);
    }

    function closeRegisterModal() {
        const modal = document.getElementById('registerModal');
        const backdrop = document.getElementById('registerModalBackdrop');
        const panel = document.getElementById('registerModalPanel');
        
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Unlock scroll (only if no other modal open)
            if (document.getElementById('loginModal').classList.contains('hidden')) {
                  document.body.classList.remove('overflow-hidden');
            }
        }, 300);
    }

    function switchToLogin() {
        closeRegisterModal();
        setTimeout(() => {
            openLoginModal();
        }, 300);
    }

    // Close on click outside
    document.getElementById('registerModal').addEventListener('click', function(e) {
        if (e.target === this || e.target.closest('#registerModalBackdrop')) {
            closeRegisterModal();
        }
    });

    // Handle AJAX Registration
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('registerBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Creating Account...';
        btn.disabled = true;

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Handle errors (display them)
                let errorMsg = 'Registration failed:\n';
                for (const [key, messages] of Object.entries(data.errors)) {
                    errorMsg += `${messages.join(', ')}\n`;
                }
                alert(errorMsg); 
                btn.innerHTML = originalText;
                btn.disabled = false;
            } else {
                // Success
                window.authCheckPassed = true; // Set flag
                closeRegisterModal();

                // 1. If server provides a specific redirect URL
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                // Update CSRF
                if (data.csrf_token) {
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.csrf_token;
                    });
                     const metaToken = document.querySelector('meta[name="csrf-token"]');
                    if (metaToken) {
                        metaToken.setAttribute('content', data.csrf_token);
                    }
                }
                
                // If there's a parent form (submission flow)
                const cardForm = document.getElementById('cardForm');
                if (cardForm) {
                    cardForm.submit();
                } else {
                    window.location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            // Optionally fall back to standard submit
            this.submit();
        });
    });
</script>
@endguest
