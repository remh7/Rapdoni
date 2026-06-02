<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            اطلاعات پروفایل
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            اطلاعات پروفایل و ایمیل حساب خود را به‌روزرسانی کنید.
        </p>
    </header>

    {{-- فرم ارسال ایمیل تأیید --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- فرم به‌روزرسانی پروفایل --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- نام --}}
        <div>
            <x-input-label for="name" value="نام" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- ایمیل --}}
        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- بررسی تأیید ایمیل --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        ایمیل شما تأیید نشده است.

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            برای ارسال مجدد ایمیل تأیید اینجا کلیک کنید.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            لینک تأیید جدید به ایمیل شما ارسال شد.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- دکمه ذخیره --}}
        <div class="flex items-center gap-4">
            <x-primary-button>ذخیره</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >ذخیره شد.</p>
            @endif
        </div>
    </form>
</section>
