<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('character_buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id');
            $table->foreignId('buildings_id');
            $table->unsignedBigInteger('count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_buildings');
    }
};
