<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Employee;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $reports = Report::all();

        return response()->json([
            'success' => true,
            'msg' => 'Reports retrievly successfully',
            'data' => $reports
        ], 201);
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
    public function store(StoreReportRequest $request)
    {
        try {
            $report = Report::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending report',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Report sent successfully',
            'data' => $report
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
            'msg' => 'Reports retrievly successfully',
            'data' => $employee->load('reports')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReportRequest $request, string $id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating report',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Report updated successfully',
            'data' => $report
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting report'
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Report deleted successfully',
        ]);
    }
}
