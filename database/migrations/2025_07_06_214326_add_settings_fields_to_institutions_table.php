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
        Schema::table('institutions', function (Blueprint $table) {
            // Add missing fields for institution settings
            $table->string('region')->nullable()->after('email');
            $table->text('address')->nullable()->after('region');
            
            // Blood bank operation settings
            $table->time('opening_time')->nullable()->after('address');
            $table->time('closing_time')->nullable()->after('opening_time');
            $table->json('operating_days')->nullable()->after('closing_time');
            $table->boolean('auto_accept_transfers')->default(false)->after('operating_days');
            
            // Blood threshold settings
            $table->json('blood_thresholds')->nullable()->after('auto_accept_transfers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn([
                'region', 
                'address',
                'opening_time',
                'closing_time',
                'operating_days',
                'auto_accept_transfers',
                'blood_thresholds'
            ]);
        });
    }
};
