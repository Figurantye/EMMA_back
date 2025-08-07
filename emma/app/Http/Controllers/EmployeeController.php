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
    /**
     * Display a listing of the resource.
     */
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

        $employees = $query->get();

        return EmployeeResource::collection($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error occurred while sending employee',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Employee sent successfully',
            'data' => $employee->load('position')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json([
            'success' => true,
            'msg' => 'Employee retrievly successfully',
            'data' => $employee->load('position', 'documents', 'laborRights', 'tags', 'reports', 'leaves', 'salaries')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating employee',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Employee updated successfully',
            'data' => $employee
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
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
            'success' => false,
            'msg' => 'Employee deleted successfully',
        ], 201);
    }

    // ... existing code ...
    public function calculate(CalculateEmployeeRequest $request, Employee $employee)
    {
        $admissionDate = Carbon::parse($employee->hired_at);
        $exitDate = Carbon::parse($request->input('termination_date'));
        $baseSalary = $employee->salary?->amount ?? 0;

        if ($baseSalary === 0) {
            return response()->json(['error' => 'Base salary not found.'], 422);
        }

        // Days worked in the month of departure
        $daysWorked = $exitDate->day;
        $salaryBalance = ($baseSalary / 30) * $daysWorked;

        // Proportional 13th salary
        $monthsWorkedInYear = $exitDate->month - 1;
        $thirteenthSalary = ($baseSalary * $monthsWorkedInYear) / 12;

        // Expired vacation (assuming a simplified method or rule)
        $expiredVacationDays = 0;
        $proportionalVacationDays = $monthsWorkedInYear;

        $expiredVacation = ($baseSalary / 30) * $expiredVacationDays;
        $proportionalVacation = ($baseSalary * $proportionalVacationDays) / 12;
        $constitutionalThird = ($expiredVacation + $proportionalVacation) / 3;

        $priorNotice = $request->boolean('paid_notice') ? $baseSalary : 0;

        $total = $salaryBalance + $expiredVacation + $proportionalVacation + $constitutionalThird + $thirteenthSalary + $priorNotice;

        return response()->json([
            'salary_balance' => round($salaryBalance, 2),
            'expired_vacation' => round($expiredVacation, 2),
            'proportional_vacation' => round($proportionalVacation, 2),
            'constitutional_third' => round($constitutionalThird, 2),
            'thirteenth_salary' => round($thirteenthSalary, 2),
            'prior_notice' => round($priorNotice, 2),
            'total' => round($total, 2),
        ]);
    }
}
