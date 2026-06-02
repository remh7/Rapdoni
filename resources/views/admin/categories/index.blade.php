@extends('layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('header', 'مدیریت دسته‌بندی‌ها')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
        <p class="text-gray-600 text-sm">تعداد کل: {{ $categories->total() }} دسته‌بندی</p>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
            + دسته‌بندی جدید
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">نام</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">اسلاگ</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">آیکون</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">ترتیب</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">تعداد آهنگ</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->icon ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->order }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->songs_count ?? 0 }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $category->is_active ? 'فعال' : 'غیرفعال' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('حذف کنم؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        دسته‌بندی وجود ندارد
                        <a href="{{ route('admin.categories.create') }}" class="text-gray-600 hover:underline block mt-2">اولین دسته‌بندی را اضافه کنید</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $categories->links() }}
    </div>
</div>
@endsection