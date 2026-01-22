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
        Schema::create('psb_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->longText('value');
            $table->string('group')->nullable();
            $table->enum('type', ['text', 'number', 'file', 'datetime'])->nullable()->default('text');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_configs');
    }
};
