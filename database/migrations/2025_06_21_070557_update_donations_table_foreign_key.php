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
    Schema::table('donations', function (Blueprint $table) {
        // Drop old foreign key
        $table->dropForeign(['donor_id']);

        // Rename column to user_id
        $table->renameColumn('donor_id', 'user_id');
    });

    Schema::table('donations', function (Blueprint $table) {
        // Add new foreign key to users table
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('donations', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->renameColumn('user_id', 'donor_id');
        $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');
    });
}
};
