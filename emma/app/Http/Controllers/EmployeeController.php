<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();

        return response()->json([
            'success' => true,
            'msg' => 'Employees retrievly successfully',
            'dataCount' => $employee->count(),
            'data' => $employee->load('position', 'documents', 'laborRights', 'tags', 'reports', 'leaves', 'salaries')
        ], 200);
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
                'msg' => 'Erro ocorred while sending employee',
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
    public function update(StoreEmployeeRequest $request, string $id)
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
    public function destroy(String $id)
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
}
