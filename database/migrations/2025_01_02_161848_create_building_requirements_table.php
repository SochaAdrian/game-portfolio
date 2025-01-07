<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('building_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buildings_id');
            $table->foreignId('resources_id');
            $table->unsignedInteger('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('building_requirements');
    }
};
