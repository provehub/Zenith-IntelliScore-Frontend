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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Plan::class)->constrained('plans');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover')->nullable();
            $table->string('agent_type')->nullable();
            $table->string('cacdoc')->nullable();
            $table->string('addressdoc')->nullable();
            $table->string('addressproof')->nullable();
            $table->string('otherdoc')->nullable();
            $table->string('company_role')->nullable();
            $table->string('website')->nullable();
            $table->string('offical_email')->nullable();
            $table->string('experience')->nullable();
            $table->string('identity')->nullable();
            $table->string('selfie')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->string('slug')->unique()->index(); // Add the slug column
            $table->longText('seo')->nullable();
            $table->longText('extras')->nullable();
            $table->integer('verif')->nullable()->default(0);
            $table->tinyInteger('isonline')->default(0)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
