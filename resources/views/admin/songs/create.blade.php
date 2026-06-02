@extends('layouts.admin')

@section('title', 'افزودن آهنگ جدید')

@section('header', 'افزودن آهنگ جدید')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- عنوان آهنگ -->
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    عنوان آهنگ <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- نام خواننده -->
            <div class="mb-5">
                <label for="artist_name" class="block text-sm font-medium text-gray-700 mb-1">
                    نام خواننده <span class="text-red-500">*</span>
                </label>
                <input type="text" name="artist_name" id="artist_name" value="{{ old('artist_name') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('artist_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- انتخاب هنرمند -->
            <div class="mb-5">
                <label for="artist_id" class="block text-sm font-medium text-gray-700 mb-1">
                    انتخاب هنرمند
                </label>
                <select name="artist_id" id="artist_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option value="">-- انتخاب هنرمند --</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-400 text-xs mt-1">در صورت انتخاب هنرمند از لیست، فیلد نام خواننده خودکار پر می‌شود</p>
                @error('artist_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- دسته‌بندی -->
            <div class="mb-5">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                    دسته‌بندی
                </label>
                <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- فایل موزیک -->
            <div class="mb-5">
                <label for="song_file" class="block text-sm font-medium text-gray-700 mb-1">
                    فایل موزیک <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition cursor-pointer" id="uploadArea">
                    <input type="file" name="song_file" id="song_file" accept=".mp3,.wav,.ogg" class="hidden" required>
                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">برای آپلود کلیک کنید</p>
                    <p class="text-gray-400 text-xs mt-1">MP3, WAV, OGG | حداکثر 10 مگابایت</p>
                    <p id="fileName" class="text-gray-600 text-sm mt-2 hidden"></p>
                </div>
                @error('song_file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- تصویر کاور -->
            <div class="mb-5">
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">
                    تصویر کاور
                </label>
                <div class="flex items-center gap-3">
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden" id="coverPreview">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('cover_image').click()" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition">
                            انتخاب عکس
                        </button>
                        <p class="text-gray-400 text-xs mt-1">JPG, PNG | حداکثر 2 مگابایت</p>
                    </div>
                </div>
                @error('cover_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- مدت زمان -->
            <div class="mb-5">
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">
                    مدت زمان (اختیاری)
                </label>
                <input type="text" name="duration" id="duration" value="{{ old('duration') }}" 
                    class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="مثال: 3:30">
                <p class="text-gray-400 text-xs mt-1">فرمت: دقیقه:ثانیه (مثل 4:25)</p>
                @error('duration')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- فعال بودن -->
            <div class="mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                        class="w-4 h-4 text-gray-600 rounded focus:ring-gray-400">
                    <span class="text-sm text-gray-700">فعال باشد (نمایش در سایت)</span>
                </label>
            </div>
            
            <!-- دکمه‌ها -->
            <div class="flex gap-3 pt-3 border-t border-gray-100">
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                    ذخیره آهنگ
                </button>
                <a href="{{ route('admin.songs.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    انصراف
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// پر کردن خودکار نام خواننده با انتخاب هنرمند
document.getElementById('artist_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var artistName = selectedOption.text;
    
    if (artistName && artistName !== '-- انتخاب هنرمند --') {
        document.getElementById('artist_name').value = artistName;
    }
});

// نمایش اسم فایل
document.getElementById('uploadArea').addEventListener('click', function() {
    document.getElementById('song_file').click();
});

document.getElementById('song_file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        document.getElementById('fileName').textContent = fileName;
        document.getElementById('fileName').classList.remove('hidden');
    }
});

// پیش‌نمایش تصویر کاور
document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('coverPreview');
            preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection