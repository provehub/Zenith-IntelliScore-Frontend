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
        Schema::create('ptops', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fulltext();
            $table->longText('description');
            $table->tinyInteger('featured')->nullable()->default(0);
            $table->string('slug')->index();
            $table->integer('status')->nullable()->default(0);
            $table->string('project_scope')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\City::class)->constrained('cities');
            $table->foreignIdFor(\App\Models\State::class)->constrained('states');
            $table->foreignIdFor(\App\Models\Country::class)->constrained('countries');
            $table->foreignIdFor(\App\Models\PtopCategory::class)->constrained('ptop_categories');
            $table->foreignIdFor(\App\Models\PtopSubCategory::class)->constrained('ptop_sub_categories');
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('timeline')->nullable();
            $table->string('deal_type')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->string('thumbnail')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptops');
    }
};
