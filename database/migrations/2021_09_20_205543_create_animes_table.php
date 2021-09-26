<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->integer('created_by');
            $table->integer('rating')->default(0);
            $table->integer('episodes_num')->nullable();
            $table->integer('episode_duration')->nullable();
            $table->integer('year_of_release')->nullable();
            $table->text('studio')->nullable();
            $table->enum('age_class', ['G','M', 'R +17', 'X +16'])->default('G');
            $table->text('categories');
            $table->text('image');
            $table->enum('completed', ['Yes','No'])->default('No');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animes');
    }
}
