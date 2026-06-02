<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
class FileController extends Controller
{
   public function create(){
    return view('upload');
   }
   public function store(Request $request){
    $request->validate([
        'file'=>'required|file|max:10240'
    ]);
    $file = File::storeUploadedFile($request->file('file'));
     return back()->with(
        'success',
        'لینک دانلود عمومی: ' . route('files.public.download', $file->token)
    );
   }
public function publicDownload($token)
{
    $file = File::where('token', $token)->firstOrFail();

    return Storage::download($file->path, $file->name);
}
}
