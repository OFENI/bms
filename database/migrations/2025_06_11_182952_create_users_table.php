<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'donor', 'institution'])->default('donor');

            // Audit columns
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_on')->nullable();

            $table->timestamps(); // created_at and updated_at (optional, but useful)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
