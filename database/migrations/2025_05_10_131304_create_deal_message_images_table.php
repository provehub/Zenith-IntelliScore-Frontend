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
        Schema::create('deal_message_images', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->foreignIdFor(\App\Models\DealMessage::class)->constrained('deal_messages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_message_images');
    }
};
