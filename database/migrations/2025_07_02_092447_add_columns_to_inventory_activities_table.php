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
            $table->unsignedBigInteger('blood_group_id')->nullable()->after('institution_id');
            $table->string('action')->nullable()->after('blood_group_id');
            $table->text('description')->nullable()->after('action');
            $table->unsignedBigInteger('created_by')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('inventory_activities', function (Blueprint $table) {
            $table->dropColumn(['blood_group_id', 'action', 'description', 'created_by']);
        });
    }
};
