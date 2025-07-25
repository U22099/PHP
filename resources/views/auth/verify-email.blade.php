<x-layout>
    <div x-data="{
        errorVerificationCodeExpired: '{{ $errors->first('verification_code_expired') }}',
        errorVerificationCode: '{{ $errors->first('verification_code') }}',
        successMessage: '{{ session('success') }}',
        otpDigits: ['', '', '', '', '', ''],
        email: '{{ $email }}',
        timeLeft: 120,
        timerInterval: null,
        showResendButton: false,
        verificationLoading: false,
        message: 'Enter the 6-digit code sent to ' + '{{ $email }}',
        messageType: 'info',
        otpInputRefs: [],
        initTimer() {
            this.timeLeft = (this.errorVerificationCodeExpired || this.errorVerificationCode) ? 0 : 120;
            this.showResendButton = false;
            this.messageType = (this.errorVerificationCodeExpired || this.errorVerificationCode) ? 'error' : this.successMessage ? 'success' : 'info';
    
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
            }
            this.timerInterval = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                    if (this.timeLeft < 60) {
                        this.showResendButton = true;
                    }
                } else {
                    clearInterval(this.timerInterval);
                    this.showResendButton = true;
                }
            }, 1000);
        },
    
        handleOtpInput(event, index) {
            let value = event.target.value;
            if (value.length > 1) {
                value = value.slice(0, 1);
                event.target.value = value;
            }
            this.otpDigits[index] = value;
    
            if (value && index < 5) {
                if (!this.otpInputRefs.length) this.getRefs();
                this.otpInputRefs[index + 1].focus();
            }
        },
    
        handleOtpKeydown(event, index) {
            if (event.key === 'Backspace') {
                if (!this.otpDigits[index] && index > 0) {
                    this.otpInputRefs[index - 1].focus();
                }
                this.otpDigits[index] = '';
            } else if (event.key === 'ArrowLeft' && index > 0) {
                this.otpInputRefs[index - 1].focus();
            } else if (event.key === 'ArrowRight' && index < 5) {
                this.otpInputRefs[index + 1].focus();
            }
        },
    
        get formattedTime() {
            const minutes = Math.floor(this.timeLeft / 60);
            const seconds = this.timeLeft % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        },
    
        submitOtpForm() {
            this.verificationLoading = true;
        },
        getRefs() {
            for (let i = 0; i < 6; i++) {
                this.otpInputRefs.push(document.getElementById('otp_input_' + i));
            }
        }
    }" x-init="initTimer();"
        class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="border p-8 rounded-lg max-w-md w-full text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Email Verification</h2>

            <div class="mb-6"
                :class="{
                    'text-blue-600': messageType === 'info',
                    'text-green-600': messageType === 'success',
                    'text-red-600': messageType === 'error',
                }"
                x-text="message"></div>

            <form method="POST" action="{{ route('auth.register.verify') }}" @submit="submitOtpForm()"
                class="space-y-6">
                @csrf

                <input type="hidden" name="verifying_email" :value="email">

                <div class="flex justify-center space-x-2 mb-6">
                    <template x-for="(digit, index) in otpDigits" :key="index">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                            autocomplete="one-time-code"
                            class="w-10 h-10 lg:w-12 lg:h-12 text-center text-2xl font-bold text-gray-900 border-2 border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200"
                            x-model="otpDigits[index]" @input="handleOtpInput($event, index)"
                            @keydown="handleOtpKeydown($event, index)" :id="'otp_input_' + index" required>
                    </template>
                </div>

                <input type="hidden" name="verification_code" :value="otpDigits.join('')">

                <button type="submit" :disabled="otpDigits.join('').length !== 6 || verificationLoading"
                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150"
                    :class="{ 'opacity-50 cursor-not-allowed': otpDigits.join('').length !== 6 || verificationLoading }">
                    <span x-show="!verificationLoading">Verify Email</span>
                    <span x-show="verificationLoading">Verifying...</span>
                </button>
            </form>

            <div class="mt-6">
                <p x-show="timeLeft > 0" class="text-gray-600 mb-2">Code expires in: <span class="font-bold"
                        x-text="formattedTime"></span>
                </p>

                <form method="POST" action="{{ '/register/verify/' . $user->id }}" x-show="showResendButton"
                    class="inline-block w-full">
                    @csrf
                    <button type="submit" :disabled="timeLeft > 60"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150"
                        :class="{ 'opacity-50 cursor-not-allowed': timeLeft > 60 }">
                        Get New Code
                    </button>
                </form>
            </div>

            @if ($errors->has('verification_code_expired'))
                <div class="mt-4 text-sm text-red-600" role="alert">
                    {{ $errors->first('verification_code_expired') }}
                </div>
            @elseif ($errors->has('verification_code'))
                <div class="mt-4 text-sm text-red-600" role="alert">
                    {{ $errors->first('verification_code') }}
                </div>
            @elseif (session('success'))
                <div class="mt-4 text-sm text-green-600" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
