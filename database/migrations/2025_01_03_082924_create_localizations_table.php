<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('localizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->foreignId('quest_id')->nullable()->constrained('quests');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('localizations');
    }
};
