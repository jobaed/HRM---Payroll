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
            $table->string('firstName', 150);
            $table->string('lastName', 150);
            $table->string('email', 200)->unique();
            $table->string('mobile', 15);
            $table->string('password', 200);
            $table->enum('role', ['admin', 'manager', 'user'])->default('user');
            $table->string('otp', 6);
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
