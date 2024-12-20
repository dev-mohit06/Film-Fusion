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
        Schema::create('likes_and_dislikes', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("movie_id");
            $table->integer("likes")->default(0);
            $table->integer("dislikes")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes_and_dislikes');
    }
};
