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
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->date('date_of_birth')->nullable();
            $table->date('hire_date');
            $table->integer('absence')->default(0); 
            $table->string('cpf')->unique();
            $table->string('rg')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->enum('employment_status', ['active', 'on_leave', 'terminated'])->default('active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
