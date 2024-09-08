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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'id')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->restrictOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments', 'id')->restrictOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('positions', 'id')->restrictOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('name');
            $table->string('photo');
            $table->string('cv')->nullable();
            $table->string('phone', 16)->unique();
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->string('address')->nullable();
            $table->date('hire_date')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->enum('source', ['invited', 'applicant']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
