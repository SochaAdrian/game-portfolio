<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('items_id');
            $table->foreignId('user_character_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_equipment');
    }
};
