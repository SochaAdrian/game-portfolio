<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('localization_npcs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('localizations_id')->nullable();
            $table->foreignId('quests_id')->nullable();
            $table->json('appearance');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('localization_npcs');
    }
};
