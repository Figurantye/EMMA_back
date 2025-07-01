<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenceRequest;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absence = Absence::all();

        return response()->json([
            'success' => true,
            'msg' => 'Absences retrievly successfully',
            'dataCount' => $absence->count(),
            'data' => $absence
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
    public function store(StoreAbsenceRequest $request)
    {
        try {
            $absence = Absence::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending absence',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Absence sent successfully',
            'data' => $absence
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
            'msg' => 'Absence retrievly successfully',
            'data' => $employee->load('absences')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAbsenceRequest $request, string $id)
    {
        try {
            $absence = Absence::findOrFail($id);
            $absence->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating absence',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Absence updated successfully',
            'data' => $absence
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $absence = Absence::findOrFail($id);
            $absence->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting absence'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Absence deleted successfully',
        ], 201);
    }
}
