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
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Deal::class)->constrained('deals');
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Payment::class)->constrained('payments');
            $table->decimal('amount',20,3);
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('others')->nullable();
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
