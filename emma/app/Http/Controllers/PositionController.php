<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $position = Position::all();

        return response()->json([
            'success' => true,
            'msg' => 'Positions retrievly successfully',
            'dataCount' => $position->count(),
            'data' => $position->load('department', 'employees')
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
    public function store(StorePositionRequest $request)
    {
        try {
            $position = Position::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Erro ocorred while sending position',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Position sent successfully',
            'data' => $position->load('department')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::findOrFail($id);

        return response()->json([
            'success' => true,
            'msg' => 'Position retrievly successfully',
            'data' => $position->load('department', 'employees')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePositionRequest $request, string $id)
    {
        try {
            $position = Position::findOrFail($id);
            $position->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating position',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Position updated successfully',
            'data' => $position
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $position = Position::findOrFail($id);
            $position->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting position'
            ], 500);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Position deleted successfully',
        ], 200);
    }
}
