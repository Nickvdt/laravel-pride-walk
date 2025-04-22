<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist_name');
            $table->string('venue_name');
            $table->json('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('special_event')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibitions');
    }
};
