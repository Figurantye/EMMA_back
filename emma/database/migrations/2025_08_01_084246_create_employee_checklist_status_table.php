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
        Schema::create('employee_checklist_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_checklist_id')->constrained()->onDelete('cascade');
            $table->foreignId('checklist_task_id')->constrained('checklist_tasks')->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->text('comments')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['onboarding_checklist_id', 'checklist_task_id'], 'onboarding_task_unique'); // evitar duplicidade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_checklist_status');
    }
};
