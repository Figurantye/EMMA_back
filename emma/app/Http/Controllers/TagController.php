<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Employee;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tags::all();

        return response()->json([
            'success' => true,
            'msg' => 'Tags retrievly successfully',
            'data' => $tags->load('employee')
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
    public function store(StoreTagRequest $request)
    {
        try {
            $tag = Tags::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending tag',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Tag sent successfully',
            'data' => $tag
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
            'msg' => 'Tags retrievly successfully',
            'data' => $employee->load('tags')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tags $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTagRequest $request, string $id)
    {
        try {
            $tag = Tags::findOrFail($id);
            $tag->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating tag',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Tag updated successfully',
            'data' => $tag
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tag = Tags::findOrFail($id);
            $tag->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting tag'
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Tag deleted successfully',
        ]);
    }
}
