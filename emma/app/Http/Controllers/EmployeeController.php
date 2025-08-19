<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['position.department', 'tags']);

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('first_name', 'like', "%$name%")
                    ->orWhere('last_name', 'like', "%$name%");
            });
        }

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->input('position_id'));
        }

        if ($request->filled('department_id')) {
            $query->whereHas('position.department', function ($q) use ($request) {
                $q->where('id', $request->input('department_id'));
            });
        }

        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->input('tag_id'));
            });
        }

        return EmployeeResource::collection($query->get());
    }

    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->only([
                'first_name',
                'last_name',
                'email',
                'date_of_birth',
                'hire_date',
                'cpf',
                'rg',
                'phone',
                'description',
                'city',
                'position_id',
                'employment_status',
                'termination_date',
                'termination_type',
                'termination_reason',
                'notice_paid',
                'severance_amount'
            ]));
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error occurred while creating employee',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Employee created successfully',
            'data' => $employee->load('position')
        ], 201);
    }

    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json([
            'success' => true,
            'msg' => 'Employee retrieved successfully',
            'data' => $employee->load('position', 'documents', 'laborRights', 'tags', 'reports', 'leaves', 'salaries')
        ], 200);
    }

    public function update(UpdateEmployeeRequest $request, string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->update($request->only([
                'first_name',
                'last_name',
                'email',
                'date_of_birth',
                'hire_date',
                'cpf',
                'rg',
                'phone',
                'description',
                'city',
                'position_id',
                'employment_status',
                'termination_date',
                'termination_type',
                'termination_reason',
                'notice_paid',
                'severance_amount'
            ]));
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error occurred while updating employee',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    public function destroy(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting employee'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Employee deleted successfully',
        ], 200);
    }

    public function calculate(CalculateEmployeeRequest $request, Employee $employee)
    {
        // Parse dates
        $hireDate = Carbon::parse($employee->hire_date);
        $terminationDate = Carbon::parse($request->input('termination_date'));

        // Get base salary
        $baseSalary = $employee->salaries()->latest()->first()?->amount ?? 0;

        if ($baseSalary <= 0) {
            return response()->json(['error' => 'Base salary not found.'], 422);
        }

        // Days worked in termination month
        $daysWorked = $terminationDate->day;
        $salaryBalance = ($baseSalary / 30) * $daysWorked;

        // Proportional 13th salary
        $monthsWorkedInYear = $terminationDate->month - 1;
        $thirteenthSalary = ($baseSalary * $monthsWorkedInYear) / 12;

        // Expired and proportional vacation
        $expiredVacationDays = 0;
        $proportionalVacationDays = $monthsWorkedInYear;

        $expiredVacation = ($baseSalary / 30) * $expiredVacationDays;
        $proportionalVacation = ($baseSalary * $proportionalVacationDays) / 12;
        $constitutionalThird = ($expiredVacation + $proportionalVacation) / 3;

        // Prior notice
        $priorNotice = $request->boolean('notice_paid') ? $baseSalary : 0;

        // Total severance calculation
        $total = $salaryBalance + $expiredVacation + $proportionalVacation + $constitutionalThird + $thirteenthSalary + $priorNotice;

        // Update employee record
        $employee->update([
            'termination_date' => $terminationDate,
            'termination_type' => $request->input('termination_type'),
            'termination_reason' => $request->input('termination_reason'),
            'notice_paid' => $request->boolean('notice_paid'),
            'severance_amount' => round($total, 2),
            'employment_status' => 'terminated',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Severance calculated and saved successfully.',
            'data' => [
                'salary_balance' => round($salaryBalance, 2),
                'expired_vacation' => round($expiredVacation, 2),
                'proportional_vacation' => round($proportionalVacation, 2),
                'constitutional_third' => round($constitutionalThird, 2),
                'thirteenth_salary' => round($thirteenthSalary, 2),
                'prior_notice' => round($priorNotice, 2),
                'total' => round($total, 2),
                'employee' => $employee->fresh(),
            ]
        ], 200);
    }
}
