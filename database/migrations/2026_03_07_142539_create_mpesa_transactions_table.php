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
    Schema::create('mpesa_transactions', function (Blueprint $table) {
        $table->id();
        $table->string('receipt_number')->nullable();
        $table->string('phone')->nullable();
        $table->decimal('amount', 10, 2)->nullable();
        $table->string('status');
        $table->string('error_code')->nullable();
        $table->string('error_message')->nullable();
        $table->timestamp('transaction_date');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpesa_transactions');
    }
};
