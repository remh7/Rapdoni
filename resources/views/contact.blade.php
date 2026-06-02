@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto my-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 text-center">
            تماس با ما
        </h1>

        {{-- پیام موفق --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
            @csrf

            {{-- نام --}}
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1" for="name">نام</label>
                <input type="text" name="name" id="name" placeholder="نام خود را وارد کنید"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- ایمیل --}}
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1" for="email">ایمیل</label>
                <input type="email" name="email" id="email" placeholder="ایمیل خود را وارد کنید"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- پیام --}}
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1" for="message">پیام</label>
                <textarea name="message" id="message" rows="5" placeholder="پیام خود را وارد کنید"
                          class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                @error('message') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- دکمه ارسال --}}
            <div class="text-center">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                    ارسال پیام
                </button>
            </div>
        </form>
    </div>

@endsection