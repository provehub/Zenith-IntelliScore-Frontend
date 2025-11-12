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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->fulltext();
            $table->string('slug')->nullable()->index();
            $table->longText('seo')->nullable();
            $table->text('description')->nullable()->fulltext();
            $table->string('image')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('total_listings')->default(0);
            $table->foreignIdFor(\App\Models\Category::class)->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
