<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mdb_id')->nullable()->unique();
            $table->float('popularity')->nullable();
            $table->integer('vote_count')->nullable();
            $table->boolean('video')->nullable();
            $table->string('poster_path')->nullable();
            $table->boolean('adult')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();;
            $table->string('title')->nullable();;
            $table->float('vote_average')->nullable();;
            $table->text('overview')->nullable();
            $table->date('release_date')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
