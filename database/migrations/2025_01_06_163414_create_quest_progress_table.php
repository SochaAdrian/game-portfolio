<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quests_id');
            $table->foreignId('user_character_id');
            $table->integer('current_value');
            $table->integer('expected_value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_progress');
    }
};
