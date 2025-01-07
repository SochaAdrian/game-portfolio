<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quest_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quests_id');
            $table->foreignId('statistics_id')->nullable();
            $table->foreignId('resources_id')->nullable();
            $table->foreignId('buildings_id')->nullable();
            $table->integer('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quest_rewards');
    }
};
