<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave = Leave::all();

        return response()->json([
            'success' => true,
            'msg' => 'Leaves retrievly successfully',
            'dataCount' => $leave->count(),
            'data' => $leave
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
    public function store(StoreLeaveRequest $request)
    {
        try {
            $leave = Leave::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Erro ocorred while sending leave',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Leave sent successfully',
            'data' => $leave->load('position')
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
            'msg' => 'Leaves retrievly successfully',
            'data' => $employee->load('leaves')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLeaveRequest $request, string $id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating leave',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Leave updated successfully',
            'data' => $leave
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting leave'
            ], 500);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Leave deleted successfully',
        ], 201);
    }
}
