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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('label');
            $table->unsignedBigInteger('amount');

            $table->date('due_date')->nullable();

            $table->enum('status', ['UNPAID', 'WAITING_CONFIRMATION', 'PAID'])
                ->default('UNPAID');

            $table->enum('payment_method', ['GATEWAY', 'MANUAL'])
                ->nullable();

            $table->string('payment_channel')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
