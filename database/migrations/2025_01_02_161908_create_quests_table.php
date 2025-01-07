<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->enum('type', ['fight', 'collect', 'talk', 'find']);
            $table->integer('requirement');
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('quest_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quests');
    }
};
