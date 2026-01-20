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
        Schema::create('registration_overrides', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // 6 digit / alphanumeric
            $table->json('allowed_paths')->nullable(); 
            
            $table->timestamp('expires_at')->nullable();

            $table->timestamp('used_at')->nullable();
            $table->foreignId('used_by_user_id')->nullable()->constrained('users');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_overrides');
    }
};
