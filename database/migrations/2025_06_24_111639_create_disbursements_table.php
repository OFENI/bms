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
        Schema::create('disbursements', function (Blueprint $table) {
           $table->id();
        $table->foreignId('blood_request_id')->constrained()->onDelete('cascade');
        $table->foreignId('institution_id')->constrained()->onDelete('cascade');
        $table->foreignId('blood_group_id')->constrained()->onDelete('cascade');
        $table->integer('quantity'); // Number of units disbursed
        $table->date('disbursed_date')->nullable();

        $table->enum('status', ['pending', 'disbursed', 'cancelled'])->default('pending');

        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();

        $table->timestamp('created_on')->nullable();
        $table->timestamp('updated_on')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursements');
    }
};
