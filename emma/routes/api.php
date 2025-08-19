<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\{
    EmployeeController,
    DepartmentController,
    ChecklistTasksController,
    OnboardingChecklistController,
    EmployeeChecklistStatusController,
    SalaryController,
    AbsenceController,
    TagController,
    LaborRightController,
    AttendanceController,
    DashboardController,
    PositionController,
    DocumentController,
    IncidentController,
    LeaveController,
    ReportController,
    AuthorizedEmailController,
    ChecklistTemplateController,
    EmployeeChecklistController,
    AuthController
};


// Google Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    Route::post('/auth/register/google', [AuthController::class, 'registerFromGoogle']);

});

// Logout Route
Route::post('logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logout successful.']);
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Recursos principais
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('incidents', IncidentController::class);

    //Checklist
    Route::apiResource('checklist-tasks', ChecklistTasksController::class);
    Route::get('employees/{employee}/onboarding-checklist', [OnboardingChecklistController::class, 'show']);
    Route::put('employee-checklist-status/{employeeChecklistStatus}', [EmployeeChecklistStatusController::class, 'update']);
    Route::apiResource('checklist-templates', ChecklistTemplateController::class);
    Route::apiResource('employee-checklists', EmployeeChecklistController::class);
    Route::get('/employees/{id}/checklists', [EmployeeChecklistController::class, 'index']);
    Route::get('/employee-checklists/{id}', [EmployeeChecklistController::class, 'show']);
    Route::patch('/employee-checklists/{employeeChecklist}/items/{itemId}', [EmployeeChecklistController::class, 'updateItemStatus']);
    Route::post('/employees/{employee}/checklists', [EmployeeChecklistController::class, 'assign']);
    Route::patch('/employee-checklists/{checklist}/items/{item}/toggle', [EmployeeChecklistController::class, 'toggleItem']);

    // Calculate
    Route::post('/employees/{employee}/calculate', [EmployeeController::class, 'calculate'])->name('employees.calculate');

    // Salários
    Route::get('employees/{employee}/salaries', [SalaryController::class, 'show']);
    Route::post('employees/{employee}/salaries', [SalaryController::class, 'store']);
    Route::put('salaries/{salary}', [SalaryController::class, 'update']);
    Route::delete('salaries/{salary}', [SalaryController::class, 'destroy']);

    // Faltas
    Route::get('employees/{employee}/absences', [AbsenceController::class, 'show']);
    Route::post('employees/{employee}/absences', [AbsenceController::class, 'store']);
    Route::put('absences/{absence}', [AbsenceController::class, 'update']);
    Route::delete('absences/{absence}', [AbsenceController::class, 'destroy']);

    // Presenças (Attendance)
    Route::get('employees/{employee}/attendances', [AttendanceController::class, 'show']);
    Route::post('employees/{employee}/attendances', [AttendanceController::class, 'store']);
    Route::put('attendances/{attendance}', [AttendanceController::class, 'update']);
    Route::delete('attendances/{attendance}', [AttendanceController::class, 'destroy']);

    // Direitos trabalhistas (Labor Rights)
    Route::get('employees/{employee}/labor-rights', [LaborRightController::class, 'index']);
    Route::post('employees/{employee}/labor-rights', [LaborRightController::class, 'store']);
    Route::put('labor-rights/{labor_right}', [LaborRightController::class, 'update']);
    Route::delete('labor-rights/{labor_right}', [LaborRightController::class, 'destroy']);

    // Tags
    Route::get('tags', [TagController::class, 'index']);
    Route::get('employees/{employee}/tags', [TagController::class, 'show']);
    Route::post('employees/{employee}/tags', [TagController::class, 'store']);
    Route::put('tags/{tag}', [TagController::class, 'update']);
    Route::delete('tags/{tag}', [TagController::class, 'destroy']);

    // Documentos
    Route::get('employees/{employee}/documents', [DocumentController::class, 'show']);
    Route::post('employees/{employee}/documents', [DocumentController::class, 'store']);
    Route::put('documents/{document}', [DocumentController::class, 'update']);
    Route::delete('documents/{document}', [DocumentController::class, 'destroy']);

    // Férias (Leaves)
    Route::get('employees/{employee}/leaves', [LeaveController::class, 'show']);
    Route::post('employees/{employee}/leaves', [LeaveController::class, 'store']);
    Route::put('leaves/{leave}', [LeaveController::class, 'update']);
    Route::delete('leaves/{leave}', [LeaveController::class, 'destroy']);

    // Relatórios
    Route::get('employees/{employee}/reports', [ReportController::class, 'show']);
    Route::post('employees/{employee}/reports', [ReportController::class, 'store']);
    Route::put('reports/{report}', [ReportController::class, 'update']);
    Route::delete('reports/{report}', [ReportController::class, 'destroy']);

    Route::get('/authorized-emails', [AuthorizedEmailController::class, 'index']);
    Route::post('/authorized-emails', [AuthorizedEmailController::class, 'store']);
    Route::delete('/authorized-emails/{id}', [AuthorizedEmailController::class, 'destroy']);
});