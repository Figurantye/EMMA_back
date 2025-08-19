<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Department;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Salary;
use App\Models\Tags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total de Funcionários
        $totalEmployees = Employee::count();

        // Férias Pendentes
        $pendingLeaves = Leave::where('status', 'pending')->count();

        // Aniversariantes do mês
        $birthdays = Employee::whereMonth('date_of_birth', now()->month)->count();

        // Funcionários por departamento
        $employeesByDepartment = Department::withCount('positions as employees_count')
            ->get()
            ->map(function ($department) {
                return [
                    'name' => $department->department,
                    'value' => Employee::whereHas('position', function ($q) use ($department) {
                        $q->where('department_id', $department->id);
                    })->count(),
                ];
            });

        // Contratações por mês (últimos 6 meses)
        $hiresByMonth = Employee::selectRaw('DATE_FORMAT(hire_date, "%Y-%m") as month, COUNT(*) as total')
            ->where('hire_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Total de faltas no mês atual
        $absencesThisMonth = Absence::whereMonth('date', now()->month)->count();

        // Faltas por tipo
        $absencesByReason = Absence::select('reason', DB::raw('count(*) as total'))
            ->groupBy('reason')
            ->get();

        // Férias por status
        $leavesByStatus = Leave::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Total da folha de pagamento
        $totalPayroll = Salary::where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>', now());
        })->sum('amount');

        // Próximos aniversariantes (próximos 5 dias)
        $upcomingBirthdays = Employee::whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") >= ?', [now()->format('m-d')])
            ->orderByRaw('DATE_FORMAT(date_of_birth, "%m-%d")')
            ->take(5)
            ->get(['first_name', 'last_name', 'date_of_birth']);

        // Documentos mais recentes
        $recentDocuments = Document::latest()->take(5)->get(['name', 'type', 'path']);

        // Tags mais utilizadas
        $topTags = Tags::select('content', DB::raw('count(*) as total'))
            ->groupBy('content')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return response()->json([
            'stats' => [
                'total_employees' => $totalEmployees,
                'pending_vacations' => $pendingLeaves,
                'birthdays' => $birthdays,
                'employees_by_department' => $employeesByDepartment,
                'hires_by_month' => $hiresByMonth,
                'absences_this_month' => $absencesThisMonth,
                'absences_by_reason' => $absencesByReason,
                'leaves_by_status' => $leavesByStatus,
                'total_payroll' => $totalPayroll,
                'upcoming_birthdays' => $upcomingBirthdays,
                'recent_documents' => $recentDocuments,
                'top_tags' => $topTags,
            ],
            'activities' => $this->getRecentActivities(),
        ]);
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Admissões recentes
        $employees = Employee::latest()->take(5)->get();
        foreach ($employees as $emp) {
            $activities[] = [
                'type' => 'employee_created',
                'message' => "new employee hired: {$emp->first_name} {$emp->last_name}",
                'created_at' => $emp->created_at,
            ];
        }

        // Leaves approved
        $leaves = Leave::where('status', 'approved')->latest()->take(5)->get();
        foreach ($leaves as $leave) {
            $emp = $leave->employee;
            $activities[] = [
                'type' => 'leave_approved',
                'message' => "leave approved for {$emp->first_name} ({$leave->type})",
                'created_at' => $leave->created_at,
            ];
        }

        // Documents added
        $docs = Document::latest()->take(5)->get();
        foreach ($docs as $doc) {
            $emp = $doc->employee;
            $activities[] = [
                'type' => 'document_added',
                'message' => "New document added by {$emp->first_name}: {$doc->name}",
                'created_at' => $doc->created_at,
            ];
        }

        // Absences
        $absences = Absence::latest()->take(5)->get();
        foreach ($absences as $abs) {
            $emp = $abs->employee;
            $activities[] = [
                'type' => 'absence_logged',
                'message' => "Absence logged for {$emp->first_name}: {$abs->reason}",
                'created_at' => $abs->created_at,
            ];
        }

        // Sort everything by date
        return collect($activities)->sortByDesc('created_at')->values()->take(10);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
