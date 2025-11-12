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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Project::class)->constrained('projects');
            $table->foreignIdFor(\App\Models\Payment::class)->constrained('payments');
            $table->decimal('amount',20,3);
            $table->string('name');
            $table->longText('audience')->nullable();
            $table->string('facebook')->nullable()->default(0);
            $table->string('instagram')->nullable()->default(0);
            $table->string('x')->nullable()->default(0);
            $table->string('linkedin')->nullable()->default(0);
            $table->string('youtube')->nullable()->default(0);
            $table->string('tiktok')->nullable()->default(0);
            $table->string('status')->nullable()->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('frequency')->nullable()->default(0);

            // $table->string('once_per_day')->nullable()->default(0);
            // $table->string('twice_per_day')->nullable()->default(0);
            // $table->string('thrice_per_day')->nullable()->default(0);
            // $table->string('once_per_week')->nullable()->default(0);
            // $table->string('twice_per_week')->nullable()->default(0);
            // $table->string('thrice_per_week')->nullable()->default(0);
            // $table->string('once_per_month')->nullable()->default(0);
            // $table->string('twice_per_month')->nullable()->default(0);
            // $table->string('thrice_per_month')->nullable()->default(0);
            // $table->string('ran_for_count')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
