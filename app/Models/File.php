<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
class File extends Model
{
    protected $fillable = ['name','path','token'];
    public static function storeUploadedFile(UploadedFile $uploadedFile){
      $path = $uploadedFile->store('uploads');
      return self::create([
        'name'=>$uploadedFile->getClientOriginalName(),
        'path'=>$path,
        'token'=>str::random(40)
      ]);
    }
}
