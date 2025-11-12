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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Deal::class)->constrained('deals');
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Payment::class)->constrained('payments');
            $table->string('name')->nullable();
            $table->longText('body')->nullable();
            $table->longText('terms')->nullable();
            $table->string('party_a')->nullable();
            $table->string('party_a_sign')->nullable();
            $table->string('party_b')->nullable();
            $table->string('party_b_sign')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('others')->nullable();
            $table->string('status')->default('processing');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
