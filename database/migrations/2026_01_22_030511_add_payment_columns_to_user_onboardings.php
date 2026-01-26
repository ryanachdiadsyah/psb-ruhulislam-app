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
            $table->enum('payment_status', ['UNPAID', 'PAID', 'EXEMPT'])
            ->after('fee_amount');

            $table->timestamp('paid_at')
                ->nullable()
                ->after('payment_status');

            $table->string('payment_reference')
                ->nullable()
                ->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_onboardings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'paid_at',
                'payment_reference',
            ]);
        });
    }
};
