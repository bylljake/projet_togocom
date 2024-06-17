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
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 155)->nullable();
            $table->string('type')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('sites_id');
            $table->foreign('sites_id')->references('id')->on('sites')->onDelete('no action');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE equipements ADD images LONGBLOB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
