<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string("movie_name")->nullable(false);
            $table->text("movie_description")->nullable(false);
            $table->string("category")->nullable(false);
            $table->string("ott_category")->nullable(false);
            $table->text("movie_poster")->nullable(false);
            $table->text("movie_banner")->nullable(false);
            $table->text("movie_file")->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
