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
    Schema::table('notifications', function (Blueprint $table) {
        // Your additional columns for email notifications
    $table->string('to_email')->nullable();
    $table->string('subject')->nullable();
    $table->text('body')->nullable();
    });
}

public function down()
{
    Schema::table('notifications', function (Blueprint $table) {
        $table->dropColumn(['to_email', 'subject', 'body']);
    });
}

};
