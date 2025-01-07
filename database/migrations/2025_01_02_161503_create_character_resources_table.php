<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('character_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_character_id');
            $table->foreignId('resources_id');
            $table->unsignedBigInteger('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('character_resources');
    }
};
