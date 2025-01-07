<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hit_attribute');
            $table->string('damage_stat');
            $table->integer('strength');
            $table->integer('dexterity');
            $table->integer('inteligence');
            $table->integer('agility');
            $table->integer('charisma');
            $table->integer('durability');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
