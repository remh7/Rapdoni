<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\SongController as FrontSongController;
use App\Http\Controllers\Admin\SongController as AdminSongController;
use App\Http\Controllers\Front\CategoryController as FrontCategoryController;
use Illuminate\Support\Facades\Route;
#...
Route::get('/categories', [FrontCategoryController::class, 'index'])->name('categories.index');
#...
Route::get('/category/{slug}', [FrontCategoryController::class, 'show'])->name('categories.show');
#...
Route::get('/',[HomeController::class,'index']);
#...
Route::get('/songs', [FrontSongController::class, 'index'])->name('songs.index');
#...
Route::get('/song/{id}',[FrontSongController::class,'show'])->name('song.show');
#...
Route::get('/download/{id}', [FrontSongController::class, 'download'])->name('song.download');
#..
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('songs', AdminSongController::class)->names('admin.songs');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('artists',AdminArtistController::class)->names('admin.artists');
});


Route::get('/contact',[ContactController::class,'create']);

Route::get('/about',function(){
return view('about');
});
Route::get('/upload', [FileController::class, 'create'])
    ->name('files.show');

Route::get('/f/{token}', [FileController::class, 'publicDownload'])
    ->name('files.public.download');

// ذخیره فایل آپلود شده
Route::post('/upload', [FileController::class, 'store'])
    ->name('files.store');

// ذخیره کامنت
Route::post('/contact',[ContactController::class,'store'])->name('contact.store');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
