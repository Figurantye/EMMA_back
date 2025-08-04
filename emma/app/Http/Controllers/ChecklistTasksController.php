<?php

namespace App\Http\Controllers;

use App\Models\ChecklistTasks;
use Illuminate\Http\Request;

class ChecklistTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChecklistTasks::orderBy('order')->get();
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $task = ChecklistTasks::create($data);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistTasks $checklistTasks)
    {
        return $checklistTasks;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistTasks $checklistTasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChecklistTasks $checklistTasks)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $checklistTasks->update($data);

        return response()->json($checklistTasks);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistTasks $checklistTasks)
    {
        $checklistTasks->delete();

        return response()->json(null, 204);
    }
}
