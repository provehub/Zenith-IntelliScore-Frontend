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
        Schema::create('liveness_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Vendor::class)->constrained('vendors');
            $table->float('age')->nullable();
            $table->string('gender')->nullable();
            $table->json('steps');           // ["mouth_open", "turn_left", ...]
            $table->json('snapshots')->nullable(); // array of base64 images
            $table->string('extras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liveness_results');
    }
};
