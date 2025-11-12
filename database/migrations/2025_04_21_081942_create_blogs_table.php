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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->string('name')->fulltext();
            $table->longText('description');
            $table->integer('status')->nullable()->default(0);
            $table->string('blog_type')->nullable()->default('text');
            $table->string('category')->nullable();
            $table->string('featured')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('slug')->nullable();
            $table->string('e1')->nullable();
            $table->string('e2')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
