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
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->string('status', 20)->change();
        });
    }
    
    public function down()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->string('status', 10)->change(); // or original length
        });
    }
    
};
