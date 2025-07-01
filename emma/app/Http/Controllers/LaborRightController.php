<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaborRightRequest;
use App\Models\LaborRight;
use Illuminate\Http\Request;

class LaborRightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laborRight = LaborRight::all();

        return response()->json([
            'success' => true,
            'msg' => 'Labor rights retrievly successfully',
            'dataCount' => $laborRight->count(),
            'data' => $laborRight
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
    public function store(StoreLaborRightRequest $request)
    {
        try {
            $laborRight = StoreLaborRightRequest::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Erro ocorred while sending labor rights',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Labor rights sent successfully',
            'data' => $laborRight
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $laborRight = LaborRight::findOrFail($id);

        return response()->json([
            'success' => true,
            'msg' => 'Employee retrievly successfully',
            'data' => $laborRight
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(laborRight $laborRight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLaborRightRequest $request, string $id)
    {
        try {
            $laborRight = LaborRight::findOrFail($id);
            $laborRight->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating labor rights',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Labor rights updated successfully',
            'data' => $laborRight
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $laborRight = LaborRight::findOrFail($id);
            $laborRight->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting labor rights'
            ], 500);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Labor rights deleted successfully',
        ], 201);
    }
}
