<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming user is authenticated
        $table->string('shipping_name');
        $table->text('shipping_address');
        $table->string('contact_number');
        $table->decimal('total_amount', 8, 2);
        $table->string('status')->default('processing'); 
        $table->timestamps();
    }); 
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
