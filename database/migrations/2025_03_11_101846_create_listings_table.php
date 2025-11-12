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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fulltext();
            $table->longText('description')->nullable();
            $table->decimal('price', 20)->nullable()->default(0);
            $table->tinyInteger('featured')->nullable();
            $table->string('slug')->index();
            $table->longText('seo')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(0);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('listing_type')->nullable()->default('videos');
            $table->unsignedInteger('duration')->nullable()->comment('Duration in minutes');
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Category::class)->constrained('categories');
            $table->foreignIdFor(\App\Models\SubCategory::class)->constrained('sub_categories');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
