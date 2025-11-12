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
        Schema::create('check_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Payment::class)->constrained('payments');
            $table->string('payment_type')->nullable();
            $table->string('charge')->nullable();
            $table->string('transaction_ref')->nullable();
            $table->text('body')->nullable();
            $table->string('others')->nullable();
            $table->string('status')->default('gateway');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_payments');
    }
};
