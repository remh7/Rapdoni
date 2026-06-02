@extends('layouts.admin')

@section('title', 'مدیریت هنرمندان')

@section('header', 'مدیریت هنرمندان')

@section('content')

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow-sm">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
        <p class="text-gray-600 text-sm">تعداد کل: {{ $artists->total() }} هنرمند</p>
        <a href="{{ route('admin.artists.create') }}" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
            + هنرمند جدید
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">آواتار</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">نام</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">سبک</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">تعداد آهنگ</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artists as $artist)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        @if($artist->avatar)
                            <img src="{{ Storage::url($artist->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                🎤
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $artist->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $artist->genre ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $artist->songs_count ?? 0 }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $artist->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $artist->is_active ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                   <a href="{{ route('admin.artists.edit', $artist->id) }}" class="text-blue-500 hover:text-blue-700">✏️</a>
<form action="{{ route('admin.artists.destroy', $artist->id) }}" method="POST" onsubmit="return confirm('حذف کنم؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">هنرمندی وجود ندارد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $artists->links() }}
    </div>
</div>
@endsection