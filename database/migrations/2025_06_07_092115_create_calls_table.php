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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Chat::class)->constrained('chats');
            $table->foreignIdFor(\App\Models\Message::class)->constrained('messages');
            $table->unsignedBigInteger('caller');
            $table->unsignedBigInteger('receiver');
            $table->foreign('caller')->references('id')->on('users');
            $table->foreign('receiver')->references('id')->on('users');
            $table->boolean('picked')->nullable()->default(false);
            $table->string('call_time')->nullable()->default('0.00');
            $table->string('call_type')->nullable();
            $table->string('channel_name')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
