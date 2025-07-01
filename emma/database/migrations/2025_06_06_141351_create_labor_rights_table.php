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
        Schema::create('labor_rights', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('contract_type');
            $table->string('workload');
            $table->string('is_unionized')->default(false);
            $table->boolean('has_fgts')->default(true);
            $table->boolean('has_inss')->default(true);
            $table->boolean('has_13th')->default(true);
            $table->boolean('has_vacation')->default(true);
            $table->boolean('transport')->default(false);
            $table->boolean('meal_voucher')->default(false);
            $table->boolean('food_voucher')->default(false);
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_rights');
    }
};
