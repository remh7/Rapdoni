@extends('layouts.admin')

@section('title', 'مدیریت آهنگ‌ها')

@section('header', 'مدیریت آهنگ‌ها')

@section('content')

{{-- نمایش پیغام موفقیت --}}
@if(session('success'))
<div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg">
    {{ session('success') }}
</div>
@endif

{{-- نمایش پیغام خطا --}}
@if(session('error'))
<div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg">
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-lg shadow-sm">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
        <p class="text-gray-600 text-sm">تعداد کل: {{ $songs->total() }} آهنگ</p>
        <a href="{{ route('admin.songs.create') }}" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
            + آهنگ جدید
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">عنوان</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">خواننده</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">دسته‌بندی</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">زمان</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">بازدید</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($songs as $song)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($song->cover_image)
                                <img src="{{ Storage::url($song->cover_image) }}" class="w-8 h-8 rounded object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center">🎵</div>
                            @endif
                            <span class="text-sm font-medium text-gray-800">{{ $song->title }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $song->artist_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $song->category->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $song->formatted_duration ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($song->plays_count) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $song->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $song->is_active ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button onclick="playSong('{{ $song->id }}', '{{ $song->file_path }}', '{{ addslashes($song->title) }}', '{{ addslashes($song->artist_name) }}')" 
                                class="text-green-500 hover:text-green-700 transition" title="پخش">
                                ▶
                            </button>
                            
                            <a href="{{ route('admin.songs.edit', $song) }}" class="text-blue-500 hover:text-blue-700 transition" title="ویرایش">
                                ✏️
                            </a>
                            
                            <form action="{{ route('admin.songs.destroy', $song) }}" method="POST" class="inline" onsubmit="return confirm('حذف کنم؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition" title="حذف">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        آهنگی وجود ندارد
                        <a href="{{ route('admin.songs.create') }}" class="text-gray-600 hover:underline block mt-2">اولین آهنگ را اضافه کنید</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $songs->links() }}
    </div>
</div>

<!-- پلیر ساده HTML5 مثل صفحه اصلی -->
<div id="playerContainer" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg transform translate-y-full transition-transform duration-300 z-50">
    <div class="container mx-auto px-4 py-2">
        <audio id="audioPlayer" class="w-full" controls>
            <source src="" type="audio/mpeg">
            مرورگر شما از پلیر صوتی پشتیبانی نمی‌کند.
        </audio>
        <div class="flex justify-between items-center mt-2 text-sm">
            <div class="flex-1">
                <span id="currentTitle" class="text-gray-800 font-medium">هیچ آهنگی انتخاب نشده</span>
                <span id="currentArtist" class="text-gray-400 text-xs mr-2"></span>
            </div>
            <button onclick="closePlayer()" class="text-gray-400 hover:text-gray-600 transition text-xl leading-none px-2">
                ✕
            </button>
        </div>
    </div>
</div>

<script>
    const audio = document.getElementById('audioPlayer');
    const playerContainer = document.getElementById('playerContainer');
    const currentTitle = document.getElementById('currentTitle');
    const currentArtist = document.getElementById('currentArtist');
    let currentSongId = null;
    
    function playSong(id, filePath, title, artist) {
        currentSongId = id;
        
        // تنظیم منبع و پخش
        audio.src = '/storage/' + filePath;
        audio.load();
        audio.play();
        
        // نمایش پلیر
        playerContainer.classList.remove('translate-y-full');
        
        // نمایش عنوان و خواننده
        currentTitle.textContent = title;
        currentArtist.textContent = artist;
        
        // ثبت بازدید
        fetch(`/song/${id}/play`, { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            } 
        }).catch(err => console.error('خطا:', err));
    }
    
    function closePlayer() {
        playerContainer.classList.add('translate-y-full');
        audio.pause();
        audio.src = '';
        currentTitle.textContent = 'هیچ آهنگی انتخاب نشده';
        currentArtist.textContent = '';
        currentSongId = null;
    }
    
    // وقتی آهنگ تموم شد
    audio.addEventListener('ended', () => {
        closePlayer();
    });
</script>
@endsection