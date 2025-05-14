<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('about_us_partner', function (Blueprint $table) {
        $table->id();
        $table->foreignId('about_us_id')->default(1)->constrained('about_us')->onDelete('cascade');
        $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('about_us_partner');
    }
};
