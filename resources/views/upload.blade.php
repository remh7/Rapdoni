@extends('layouts.app')

@section('title', 'آپلود فایل')

@section('content')

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

   <div class="max-w-md mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">

    <h1 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
        آپلود فایل
    </h1>

    <form action="{{ route('files.store') }}" method="POST" 
          enctype="multipart/form-data"
          class="space-y-4"
          id="uploadForm">
        
        @csrf

        <!-- مقدار انتخاب فایل -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                انتخاب فایل
            </label>
            <input
                type="file"
                name="file"
                required
                class="block w-full text-sm text-gray-700 dark:text-gray-300
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:bg-indigo-600 file:text-white
                       hover:file:bg-indigo-700
                       border border-gray-300 rounded-md px-4 py-2 dark:border-gray-600"
                id="fileInput"
            >
        </div>

        <!-- دکمه آپلود -->
        <button
            type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:-translate-y-0.5 shadow-md"
        >
            آپلود
        </button>

        <!-- نمایش پیشرفت آپلود (در حالی که فایل آپلود می‌شود) -->
        <div id="uploadProgress" class="hidden mt-4">
            <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">آپلود در حال انجام...</div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div id="progressBar" class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
            </div>
            <div id="progressText" class="text-xs text-gray-500 mt-1">پیشرفت: 0%</div>
        </div>

    </form>

</div>


@endsection
<script>
document.getElementById('uploadForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // منع تبدیل فرم

    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (!file) return alert("فایل را انتخاب کنید!");

    const formData = new FormData();
    formData.append('file', file);

    // نمایش پیشرفت
    const progressContainer = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    progressContainer.classList.remove('hidden');

    let uploadedSize = 0;
    let totalSize = file.size;

    // مراقبت از پیشرفت
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("files.store") }}', true);
    
    xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
            const percentComplete = Math.round((event.loaded / event.total) * 100);
            uploadedSize = event.loaded;
            totalSize = event.total;

            progressBar.style.width = `${percentComplete}%`;
            progressText.textContent = `پیشرفت: ${percentComplete}%`;
        }
    });

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("فایل با موفقیت آپلود شد!");
            // می‌تونی بخوای حذف کنی یا صفحه را تغییر بده
        } else {
            alert("خطا در آپلود فایل");
        }
    };

    xhr.onerror = function() {
        alert("خطا در ارتباط با سرور.");
    };

    // فرستادن داده
    xhr.send(formData);
});
</script>
