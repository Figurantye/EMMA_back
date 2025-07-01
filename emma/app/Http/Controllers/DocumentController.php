<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document = Document::all();

        return response()->json([
            'success' => true,
            'msg' => 'Documents retrievly successfully',
            'dataCount' => $document->count(),
            'data' => $document->load('employee')
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
    public function store(StoreDocumentRequest $request)
    {
        try {
            $document = Document::create($request->validated());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while sending document',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Document sent successfully',
            'data' => $document
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
            'msg' => 'Documents retrievly successfully',
            'data' => $employee->load('documents')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDocumentRequest $request, string $id)
    {
        try {
            $document = Document::findOrFail($id);
            $document->update($request->all());
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error ocorred while updating document',
                'error' => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Document updated successfully',
            'data' => $document
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $document = Document::findOrFail($id);
            $document->delete();
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Error while deleting document'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Document deleted successfully',
        ], 201);
    }
}
