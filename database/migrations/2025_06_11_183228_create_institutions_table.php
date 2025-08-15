<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
           $table->id(); // Primary key
            $table->string('name');
            $table->string('location');
            $table->string('contact_number');
            

            // Audit columns
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_on')->nullable();

            $table->timestamps(); // Optional but handy
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
