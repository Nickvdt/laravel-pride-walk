<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_visits', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->integer('visit_count')->default(1);
            $table->date('visited_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_visits');
    }
};