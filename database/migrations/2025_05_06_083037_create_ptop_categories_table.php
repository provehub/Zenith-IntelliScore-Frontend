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
        Schema::create('ptop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fulltext();
            $table->text('description')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('image')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('total_listings')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptop_categories');
    }
};
