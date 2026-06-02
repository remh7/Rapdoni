@extends('layouts.admin')

@section('title', 'داشبورد')

@section('header', 'داشبورد مدیریت')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- کارت 1 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="text-3xl">🎵</div>
            <div class="text-xs text-gray-400">کل</div>
        </div>
        <div class="text-gray-600 text-sm mb-1">تعداد آهنگ‌ها</div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalSongs ?? 0 }}</div>
    </div>

    <!-- کارت 2 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="text-3xl">👥</div>
            <div class="text-xs text-gray-400">کل</div>
        </div>
        <div class="text-gray-600 text-sm mb-1">کاربران</div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
    </div>

    <!-- کارت 3 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="text-3xl">▶️</div>
            <div class="text-xs text-gray-400">کل</div>
        </div>
        <div class="text-gray-600 text-sm mb-1">کل پخش‌ها</div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalPlays ?? 0 }}</div>
    </div>
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-800">آخرین آهنگ‌های اضافه شده</h2>
        <p class="text-xs text-gray-400 mt-1">جدیدترین آثار موسیقی</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-right p-4 text-sm font-medium text-gray-600">عنوان</th>
                    <th class="text-right p-4 text-sm font-medium text-gray-600">خواننده</th>
                    <th class="text-right p-4 text-sm font-medium text-gray-600">تاریخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestSongs ?? [] as $song)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4 text-gray-800">{{ $song->title }}</td>
                    <td class="p-4 text-gray-600">{{ $song->artist_name }}</td>
                    <td class="p-4 text-gray-500 text-sm">{{ $song->created_at->format('Y/m/d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-gray-400">هیچ آهنگی وجود ندارد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection