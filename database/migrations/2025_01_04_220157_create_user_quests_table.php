<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('character_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id');
            $table->foreignId('quests_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_quests');
    }
};
