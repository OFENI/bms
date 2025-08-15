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
            $table->unsignedBigInteger('blood_group_id')->nullable()->after('institution_id');
    
            // If you're using foreign key constraints:
            $table->foreign('blood_group_id')->references('id')->on('blood_groups')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['blood_group_id']);
            $table->dropColumn('blood_group_id');
        });
    }
    
};
