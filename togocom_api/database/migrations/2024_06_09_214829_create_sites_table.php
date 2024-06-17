<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 155)->unique();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->integer('superficie')->nullable();
            $table->date('date_of_create');
            $table->date('date_of_service');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE sites ADD images LONGBLOB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
