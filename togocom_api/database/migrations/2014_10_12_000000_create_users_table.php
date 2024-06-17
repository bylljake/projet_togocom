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
            $table->string('firstname', 155);
            $table->string('lastname', 155);
            $table->string('username', 20)->unique();
            $table->string('role', 20)->default('user');
            $table->string('email', 120)->unique();
            $table->char('gender', 1)->nullable();;
            $table->string('phone',30)->nullable();
            $table->date('birthday', 20)->nullable();
            $table->string('place_of_birth', 120)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();;
            $table->rememberToken();
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
