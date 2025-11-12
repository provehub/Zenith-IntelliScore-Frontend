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
        Schema::create('promoteds', function (Blueprint $table) {
            $table->id();
            $table->integer('days')->nullable()->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Listing::class)->constrained('listings');
            $table->foreignIdFor(\App\Models\Promotion::class)->constrained('promotions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoteds');
    }
};
