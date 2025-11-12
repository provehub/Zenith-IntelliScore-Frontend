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
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->longText('bio')->nullable();
            $table->timestamp('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('nationality')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->string('marital_status')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->string('blood_type')->nullable();
            $table->json('medical_conditions')->nullable();
            $table->json('disabilities')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('crypto_wallet_address')->nullable();
            $table->string('preferred_language')->nullable();
            $table->string('preferred_currency')->nullable();
            $table->string('timezone')->nullable();
            $table->json('notification_preferences')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamp('privacy_policy_accepted_at')->nullable();
            $table->boolean('is_blacklisted')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
