<?php

namespace App\Http\Controllers;

use App\Models\checklist_tasks;
use Illuminate\Http\Request;

class ChecklistTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChecklistTask::orderBy('order')->get();
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

        $task = ChecklistTask::create($data);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(checklist_tasks $checklist_tasks)
    {
        return $checklistTask;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(checklist_tasks $checklist_tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, checklist_tasks $checklist_tasks)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $checklistTask->update($data);

        return response()->json($checklistTask);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(checklist_tasks $checklist_tasks)
    {
        $checklistTask->delete();

        return response()->json(null, 204);
    }
}
