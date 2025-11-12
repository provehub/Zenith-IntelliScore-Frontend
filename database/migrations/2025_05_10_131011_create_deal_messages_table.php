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
        Schema::create('deal_messages', function (Blueprint $table) {
            $table->id();
            $table->boolean('sender')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->foreignIdFor(\App\Models\Deal::class)->constrained('deals');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_messages');
    }
};
