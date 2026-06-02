@extends('layouts.admin')

@section('title', 'افزودن هنرمند جدید')

@section('header', 'افزودن هنرمند جدید')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">نام هنرمند *</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">آواتار</label>
                <input type="file" name="avatar" accept="image/*" class="w-full">
                @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">سبک</label>
                <input type="text" name="genre" value="{{ old('genre') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('genre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">تاریخ تولد</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">بیوگرافی</label>
                <textarea name="bio" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('bio') }}</textarea>
                @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="text-sm text-gray-700">فعال باشد</span>
                </label>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">ذخیره</button>
                <a href="{{ route('admin.artists.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">انصراف</a>
            </div>
        </form>
    </div>
</div>
@endsection