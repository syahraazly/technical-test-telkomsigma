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
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female']); 
            $table->string('role');
            $table->string('job_grade');
            $table->string('employment_no')->unique();
            $table->enum('employment_status', ['Contract', 'Permanent', 'Probation']); 
            $table->string('manager');
            $table->date('join_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employments');
    }
};
