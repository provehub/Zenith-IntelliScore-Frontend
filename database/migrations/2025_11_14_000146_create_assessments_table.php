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
        Schema::create('assessments', function (Blueprint $t) {
            $t->id();
            $t->foreignIdFor(\App\Models\Project::class)->constrained('projects');
            $t->string('account_name');
            $t->string('account_no');
            $t->string('period')->nullable();

            $t->integer('credit_trust_score');
            $t->string('risk_band', 2);
            $t->decimal('pd_90d', 6, 4);

            $t->json('meta')->nullable();      // full meta from parser
            $t->json('features')->nullable();  // full features
            $t->json('score')->nullable();     // full score JSON incl. top_feature_impacts

            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
