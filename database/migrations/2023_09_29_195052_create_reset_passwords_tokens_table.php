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
        Schema::create('reset_passwords_tokens', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->text("token");
            $table->timestamp("expire_time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reset_passwords_links');
    }
};
