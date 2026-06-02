@extends('layouts.app')

@section('title', 'خانه')

@section('content')
<div class="bg-gray-100 min-h-screen pb-28">
    
    <!-- هدر ساده -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-12 text-center">
            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-light text-gray-800 mb-2">رپدونی</h1>
            <p class="text-gray-400 text-sm">جدیدترین آهنگ‌های رپ و هیپ‌هاپ</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <!-- بخش جستجو -->
        <div class="mb-12">
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('songs.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request()->get('search') }}" 
                           placeholder="جستجوی آهنگ، خواننده، آلبوم..."
                           class="w-full px-5 py-3 pr-12 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent shadow-sm">
                    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
                
                <!-- نتایج جستجو (اگه از صفحه اصلی جستجو شده باشه) -->
                @if(request()->has('search') && request()->get('search'))
                <div class="mt-6 p-4 bg-white rounded-xl shadow-sm">
                    <p class="text-gray-600 text-sm">
                        نتایج جستجو برای: 
                        <span class="font-medium text-gray-800">"{{ request()->get('search') }}"</span>
                    </p>
                    <a href="{{ route('songs.index', ['search' => request()->get('search')]) }}" class="text-gray-500 text-sm hover:text-gray-800 transition mt-2 inline-block">
                        مشاهده همه نتایج →
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- جدیدترین آهنگ‌ها -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-gray-700 text-base font-medium">جدیدترین</h2>
                <a href="{{ route('songs.index') }}" class="text-gray-400 text-xs hover:text-gray-600 transition">مشاهده همه</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($latestSongs as $song)
                <div class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer" 
                     onclick="window.location.href='{{ route('song.show', $song->id) }}'">
                    <div class="aspect-square bg-gray-50 flex items-center justify-center relative">
                        @if($song->cover_image)
                            <img src="{{ Storage::url($song->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        @endif
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition">
                            <div class="bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-gray-800 text-sm font-medium truncate">{{ $song->title }}</h3>
                        <p class="text-gray-400 text-xs mt-1 truncate">{{ $song->artist_name }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center text-gray-400 py-12">هیچ آهنگی وجود ندارد</div>
                @endforelse
            </div>
        </section>
        
        <!-- پربازدیدترین -->
        <section class="mb-12">
            <h2 class="text-gray-700 text-base font-medium mb-4">پربازدیدترین</h2>
            
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @forelse($popularSongs as $index => $song)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-0"
                     onclick="window.location.href='{{ route('song.show', $song->id) }}'">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if($song->cover_image)
                                <img src="{{ Storage::url($song->cover_image) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-gray-800 text-sm font-medium">{{ $song->title }}</h3>
                            <p class="text-gray-400 text-xs">{{ $song->artist_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-400 text-xs">{{ number_format($song->plays_count) }}</span>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-12">هیچ آهنگی وجود ندارد</div>
                @endforelse
            </div>
        </section>
        
        <!-- دسته‌بندی‌ها -->
        <section>
            <h2 class="text-gray-700 text-base font-medium mb-4">دسته‌بندی‌ها</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                <a href="{{ route('songs.index', ['category' => $category->id]) }}" class="px-3 py-1.5 bg-white text-gray-600 text-sm rounded-md hover:bg-gray-800 hover:text-white transition shadow-sm">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </section>
    </div>
</div>

<!-- پلیر ساده HTML5 -->
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
        
        audio.src = '/storage/' + filePath;
        audio.load();
        audio.play();
        
        playerContainer.classList.remove('translate-y-full');
        
        currentTitle.textContent = title;
        currentArtist.textContent = artist;
        
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
    
    audio.addEventListener('ended', () => {
        closePlayer();
    });
</script>
@endsection