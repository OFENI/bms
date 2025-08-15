<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('blood_group_id')->constrained('blood_groups')->onDelete('cascade');

            $table->enum('requested_by', ['individual', 'institution']);
            $table->unsignedInteger('quantity');

            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->date('requested_date');
            $table->date('fulfilled_date')->nullable();

            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_on')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
