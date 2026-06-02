@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')


        
<header>
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('داشبورد') }}
</h2>
</header>
       

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("شما وارد شدید! خوش اومدید") }}
                </div>
            </div>
        </div>
    </div>
@endsection