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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            // optional link to your local users table
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('provider', 32);               // e.g. 'x'
            $table->string('provider_user_id', 64);       // X user id (numeric)
            $table->string('username')->nullable();       // X handle
            $table->text('access_token');                 // OAuth2 user token
            $table->text('refresh_token')->nullable();    // if offline.access
            $table->timestamp('expires_at')->nullable();  // when access_token expires
            $table->text('scope')->nullable();
            $table->json('meta')->nullable();             // whatever extra
            $table->timestamps();

            $table->unique(['provider', 'provider_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
