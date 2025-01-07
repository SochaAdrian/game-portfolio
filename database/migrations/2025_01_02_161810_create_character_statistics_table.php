<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('character_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_character_id');
            $table->foreignId('statistics_id');
            $table->integer('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('character_statistics');
    }
};
