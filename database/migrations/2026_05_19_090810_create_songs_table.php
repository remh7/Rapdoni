<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist_name');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('file_path'); // مسیر فایل mp3
            $table->string('cover_image')->nullable(); // تصویر کاور
            $table->integer('duration')->default(0); // مدت زمان به ثانیه
            $table->integer('plays_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};