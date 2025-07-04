<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentRequest;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::with('employee')->get();

        return response()->json([
            'success' => true,
            'msg' => 'Incidents retrievly successfully',
            'dataCount' => $incidents->count(),
            'data' => $incidents
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
    public function store(StoreIncidentRequest $request)
    {
        try {
            $incident = Incident::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Erro ocorred while sending incident',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Incident sent successfully',
            'data' => $incident
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incident = Incident::findOrFail($id);

        return response()->json([
            'success' => true,  
            'msg' => 'Incident retrievly successfully',
            'data' => $incident
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIncidentRequest $request, string $id)
    {
        try {
            $incident = Incident::findOrFail($id);
            $incident->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating incident',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Incident updated successfully',
            'data' => $incident
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $incident = Incident::findOrFail($id);
            $incident->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting incident'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Incident deleted successfully',
        ], 201);
    }
}
