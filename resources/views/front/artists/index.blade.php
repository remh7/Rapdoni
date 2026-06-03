@extends('layouts.app')

@section('title', 'هنرمندان')

@section('content')
<div class="bg-gray-100 min-h-screen pb-20">
    
    <!-- هدر صفحه -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-12 text-center">
            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-light text-gray-800 mb-2">هنرمندان</h1>
            <p class="text-gray-400 text-sm">بهترین خوانندگان رپ و هیپ‌هاپ</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <!-- تعداد نتایج -->
        <div class="mb-6">
            <p class="text-gray-400 text-sm">تعداد کل: {{ $artists->total() }} هنرمند</p>
        </div>
        
        <!-- لیست هنرمندان -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
        @forelse($artists as $artist)
    @if($artist->slug)
        <a href="{{ route('artists.show', ['slug' => $artist->slug]) }}" class="group">
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative">
                    @if($artist->avatar)
                        <img src="{{ Storage::url($artist->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-4xl text-gray-500">🎤</span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition"></div>
                </div>

                <div class="p-3 text-center">
                    <h3 class="text-gray-800 font-medium text-sm truncate">
                        {{ $artist->name }}
                    </h3>

                    <p class="text-gray-400 text-xs mt-1">
                        {{ $artist->songs_count }} آهنگ
                    </p>
                </div>
            </div>
        </a>
    @endif
@empty
    <div class="col-span-full text-center text-gray-400 py-16">
        هنرمندی وجود ندارد
    </div>
@endforelse
        </div>
        
        <!-- صفحه‌بندی -->
        <div class="mt-8">
            {{ $artists->links() }}
        </div>
    </div>
</div>
@endsection