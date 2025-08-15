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
        Schema::table('blood_requests', function (Blueprint $table) {
            // ✅ Rename institution_id to requester_id
            if (Schema::hasColumn('blood_requests', 'institution_id')) {
                $table->renameColumn('institution_id', 'requester_id');
            }

            // ✅ Add requested_from_id
            if (!Schema::hasColumn('blood_requests', 'requested_from_id')) {
                $table->unsignedBigInteger('requested_from_id')->nullable()->after('requester_id');
            }

            // ✅ Add urgency_level
            if (!Schema::hasColumn('blood_requests', 'urgency_level')) {
                $table->enum('urgency_level', ['normal', 'urgent'])->default('normal')->after('quantity');
            }

            // ✅ Add notes
            if (!Schema::hasColumn('blood_requests', 'notes')) {
                $table->text('notes')->nullable()->after('urgency_level');
            }

            // ✅ Add fulfilled_by
            if (!Schema::hasColumn('blood_requests', 'fulfilled_by')) {
                $table->unsignedBigInteger('fulfilled_by')->nullable()->after('requested_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            // Reverse the changes safely
            if (Schema::hasColumn('blood_requests', 'requested_from_id')) {
                $table->dropColumn('requested_from_id');
            }
            if (Schema::hasColumn('blood_requests', 'urgency_level')) {
                $table->dropColumn('urgency_level');
            }
            if (Schema::hasColumn('blood_requests', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('blood_requests', 'fulfilled_by')) {
                $table->dropColumn('fulfilled_by');
            }

            if (Schema::hasColumn('blood_requests', 'requester_id')) {
                $table->renameColumn('requester_id', 'institution_id');
            }
        });
    }
};
