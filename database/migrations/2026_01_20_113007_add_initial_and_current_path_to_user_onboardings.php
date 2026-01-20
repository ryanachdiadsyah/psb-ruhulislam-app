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
        Schema::table('user_onboardings', function (Blueprint $table) {
            $table->foreignId('initial_registration_path_id')
                ->after('user_id')
                ->constrained('registration_paths');

            $table->foreignId('current_registration_path_id')
                ->after('initial_registration_path_id')
                ->constrained('registration_paths');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_onboardings', function (Blueprint $table) {
            //
        });
    }
};
