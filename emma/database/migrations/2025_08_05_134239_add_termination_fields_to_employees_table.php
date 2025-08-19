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
        Schema::table('employees', function (Blueprint $table) {
            $table->date('termination_date')->nullable()->after('employment_status');
            $table->enum('termination_type', ['without_cause', 'resignation', 'with_cause'])->nullable()->after('termination_date');
            $table->text('termination_reason')->nullable()->after('termination_type');
            $table->boolean('notice_paid')->default(false)->after('termination_reason');
            $table->decimal('severance_amount', 10, 2)->nullable();
            $table->date('last_vacation_date')->nullable()->after('severance_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'termination_date',
                'termination_type',
                'termination_reason',
                'notice_paid',
            ]);
        });
    }
};
