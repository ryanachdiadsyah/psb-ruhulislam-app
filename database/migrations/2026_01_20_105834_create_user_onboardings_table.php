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
        Schema::create('user_onboardings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->foreignId('registration_path_id')->constrained();
            $table->foreignId('information_source_id')->constrained();

            $table->string('invite_code_used')->nullable();
            $table->string('override_code_used')->nullable();

            $table->unsignedInteger('fee_amount')->default(0);

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_onboardings');
    }
};
