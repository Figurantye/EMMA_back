<?php

namespace App\Http\Controllers;

use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChecklistTemplateRequest;
use App\Http\Requests\UpdateChecklistTemplateRequest;

class ChecklistTemplateController extends Controller
{
    public function index()
    {
        return ChecklistTemplate::with('items')->get();
    }

    public function store(StoreChecklistTemplateRequest $request)
    {
        $template = ChecklistTemplate::create($request->only(['name', 'description']));

        foreach ($request->items as $item) {
            $template->items()->create($item);
        }

        return response()->json($template->load('items'), 201);
    }

    public function show(ChecklistTemplate $checklistTemplate)
    {
        return $checklistTemplate->load('items');
    }

    public function update(UpdateChecklistTemplateRequest $request, ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->update($request->only(['name', 'description']));

        if ($request->has('items')) {
            // Limpar itens antigos
            $checklistTemplate->items()->delete();

            // Criar os novos
            foreach ($request->items as $item) {
                $checklistTemplate->items()->create($item);
            }
        }

        return $checklistTemplate->load('items');
    }

    public function destroy(ChecklistTemplate $checklistTemplate)
    {
        $checklistTemplate->delete();
        return response()->noContent();
    }
}
