<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProfilePhotoPathFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path'); // Drop the column here
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_path')->nullable(); // Add the column back in case of rollback
        });
    }
}
