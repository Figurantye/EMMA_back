<?php

namespace App\Http\Controllers;

use App\Models\ChecklistTemplate;
use App\Models\ChecklistTemplateItem;
use App\Models\Employee;
use App\Models\EmployeeChecklist;
use App\Models\EmployeeChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeChecklistController extends Controller
{
    // Listar todos checklists de um funcionário (passar ?employee_id=1)
    public function index($employeeId)
    {
        $checklists = EmployeeChecklist::with('template', 'items.templateItem')
            ->where('employee_id', $employeeId)
            ->get();

        return response()->json($checklists);
    }

    // Mostrar checklist específico com itens e respostas
    public function show(EmployeeChecklist $employeeChecklist)
    {
        $employeeChecklist->load(['template', 'items.templateItem']);
        return response()->json($employeeChecklist);
    }

    // Criar nova atribuição de checklist para funcionário
    public function store(Request $request, $employeeId)
    {
        $request->validate([
            'checklist_template_id' => 'required|exists:checklist_templates,id',
        ]);

        $template = ChecklistTemplate::with('items')->findOrFail($request->checklist_template_id);

        $employeeChecklist = EmployeeChecklist::create([
            'employee_id' => $employeeId,
            'checklist_template_id' => $template->id,
            'status' => 'pending',
            'progress' => 0,
        ]);

        foreach ($template->items as $item) {
            $employeeChecklist->items()->create([
                'title' => $item->title,
                'completed' => false,
                'checklist_template_item_id' => $item->id,
            ]);
        }

        // ⬇️ Correção aqui:
        return response()->json($employeeChecklist->load('template', 'items.templateItem'), 201);
    }



    // Atualizar respostas do checklist e status
    public function update(Request $request, $id)
    {
        $checklist = EmployeeChecklist::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'in:pending,in_progress,completed',
            'items' => 'array',
            'items.*.id' => 'required|exists:employee_checklist_items,id',
            'items.*.completed' => 'boolean',
            'items.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('status')) {
            $checklist->status = $request->status;
        }

        $checklist->save();

        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $item = EmployeeChecklistItem::find($itemData['id']);
                if ($item && $item->employee_checklist_id == $checklist->id) {
                    $item->completed = $itemData['completed'] ?? $item->completed;
                    $item->notes = $itemData['notes'] ?? $item->notes;
                    $item->save();
                }
            }
        }

        return response()->json($checklist->load('items.templateItem'));
    }

    // Deletar checklist atribuído (opcional)
    public function destroy($id)
    {
        $checklist = EmployeeChecklist::findOrFail($id);
        $checklist->delete();

        return response()->noContent();
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'checklist_template_id' => 'required|exists:checklist_templates,id',
        ]);

        // Cria o checklist atribuído ao funcionário
        $checklist = EmployeeChecklist::create([
            'employee_id' => $validated['employee_id'],
            'checklist_template_id' => $validated['checklist_template_id'],
            'status' => 'pending',
        ]);

        // Busca os itens do template
        $templateItems = ChecklistTemplateItem::where('checklist_template_id', $validated['checklist_template_id'])->get();

        // Copia cada item para a tabela de items atribuídos ao funcionário
        foreach ($templateItems as $item) {
            EmployeeChecklistItem::create([
                'employee_checklist_id' => $checklist->id,
                'checklist_template_item_id' => $item->id,
                'completed' => false,
                'notes' => null,
            ]);
        }

        return response()->json($checklist->load('template', 'items.templateItem'), 201);
    }


    public function updateItemStatus(Request $request, EmployeeChecklist $employeeChecklist, $itemId)
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        $item = $employeeChecklist->items()->where('id', $itemId)->firstOrFail();
        $item->completed = $request->completed;
        $item->save();

        // Recalcular o progresso
        $total = $employeeChecklist->items()->count();
        $completed = $employeeChecklist->items()->where('completed', true)->count();
        $employeeChecklist->progress = round(($completed / $total) * 100);
        $employeeChecklist->status = $employeeChecklist->progress === 100 ? 'completed' : 'in_progress';
        $employeeChecklist->save();

        return response()->json([
            'message' => 'Item atualizado com sucesso.',
            'progress' => $employeeChecklist->progress,
            'status' => $employeeChecklist->status,
        ]);
    }

    public function toggleItem($checklistId, $itemId)
    {
        $item = EmployeeChecklistItem::where('employee_checklist_id', $checklistId)
            ->where('id', $itemId)
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }

        $item->completed = !$item->completed;
        $item->save();

        return response()->json(['message' => 'Status atualizado com sucesso']);
    }

    
}
