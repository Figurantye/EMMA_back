<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::all();

        return response()->json([
            'success' => true,
            'msg' => 'Attendances retrievly successfully',
            'dataCount' => $attendances->count(),
            'data' => $attendances
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
    public function store(StoreAttendanceRequest $request)
    {
        try {
            $attendance = Attendance::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending attendance',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Attendance sent successfully',
            'data' => $attendance
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
            'msg' => 'Attendance retrievly successfully',
            'data' => $employee->load('attendances')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttendanceRequest $request, string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating attendance',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Attendance updated successfully',
            'data' => $attendance
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting attendance'
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Attendance deleted successfully',
        ]);
    }
}
