@extends('layouts.admin')

@section('title', 'دسته‌بندی جدید')

@section('header', 'دسته‌بندی جدید')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    نام دسته‌بندی <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    اسلاگ (خالی بذاری خودکار میسازه)
                </label>
                <input type="text" name="slug" value="{{ old('slug') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="text-gray-400 text-xs mt-1">مثال: pop-music</p>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    توضیحات
                </label>
                <textarea name="description" rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    آیکون
                </label>
                <input type="text" name="icon" value="{{ old('icon') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                    placeholder="🎵">
                <p class="text-gray-400 text-xs mt-1">یک ایموجی یا آیکون ساده</p>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    رنگ
                </label>
                <input type="color" name="color" value="{{ old('color', '#6366f1') }}" 
                    class="w-20 h-10 border border-gray-300 rounded cursor-pointer">
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    ترتیب نمایش
                </label>
                <input type="number" name="order" value="{{ old('order', 0) }}" 
                    class="w-32 px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div class="mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="text-sm text-gray-700">فعال باشد</span>
                </label>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                    ذخیره
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    انصراف
                </a>
            </div>
        </form>
    </div>
</div>
@endsection