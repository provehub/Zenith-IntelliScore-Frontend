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
        Schema::create('x_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->foreignIdFor(\App\Models\Project::class)->constrained('projects');
            $table->string('username')->nullable();
            $table->string('name')->nullable(); 
            $table->text('account_id')->nullable();  
            $table->longText('access_token');              
            $table->longText('access_token_secret')->nullable();
            $table->longText('consumer_key')->nullable();
            $table->longText('consumer_secret')->nullable();
            $table->longText('bearer_token')->nullable();
            $table->longText('refresh_token')->nullable();   
            $table->timestamp('expires_at')->nullable(); 
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('x_accounts');
    }
};
