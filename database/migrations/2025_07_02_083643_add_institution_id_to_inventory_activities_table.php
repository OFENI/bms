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
        Schema::table('inventory_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('institution_id')->after('id');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('inventory_activities', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
            $table->dropColumn('institution_id');
        });
    }
};
