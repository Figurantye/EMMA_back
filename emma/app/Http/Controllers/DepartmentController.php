<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department = Department::all();

        return response()->json([
            'success' => true,
            'msg' => 'Departments retrievly successfully',
            'dataCount' => $department->count(),
            'data' => $department->load('positions')
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
    public function store(StoreDepartmentRequest $request)
    {
        try {
            $department = Department::create($request->validated());
        } catch (\Exception $error) {

            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending department',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Department sent successfully',
            'data' => $department
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return response()->json([
            'success' => true,  
            'msg' => 'Department retrievly successfully',
            'data' => $department->load('positions')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepartmentRequest $request, string $id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating department',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Department updated successfully',
            'data' => $department
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting department'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Department deleted successfully',
        ], 201);
    }
}
