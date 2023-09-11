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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username")->nullable()->unique();
            $table->string("email")->nullable()->unique();
            $table->string("password")->nullable(false);
            $table->text("profile_picture")->nullable(false);
            $table->integer("role")->nullable(false)->default(0);
            $table->integer("account_status")->nullable(false)->default(0);
            $table->integer("subscription_status")->nullable(false)->default(0);
            $table->string("verification_token")->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
