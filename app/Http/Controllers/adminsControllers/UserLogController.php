<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
use App\Models\user_log;
use Carbon\Carbon;
use ExcelJS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserLogsExport;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query for table
        $query = user_log::with(['user.user_details'])
            ->select('id', 'user_id', 'action', 'created_at', 'ip_address')
            ->latest();

        // Apply filters
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->whereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfWeek();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfWeek();
        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Paginate logs
        $users_logs = $query->paginate(6);

        // Get unique actions
        $actions = user_log::select('action')->distinct()->pluck('action')->toArray();

        // Chart data
        $logs = user_log::whereBetween('created_at', [$startDate, $endDate])
            ->select('created_at')
            ->get();

        $logsByDay = $logs->groupBy(function ($log) {
            return ucfirst(Carbon::parse($log->created_at)->locale('fr')->isoFormat('dddd'));
        });

        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $loginCounts = [];
        foreach ($days as $day) {
            $loginCounts[] = isset($logsByDay[$day]) ? $logsByDay[$day]->count() : 0;
        }

        // Overview metrics
        $todayLogins = user_log::whereDate('created_at', Carbon::today())->count();
        $weekLogins = user_log::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $uniqueUsers = user_log::whereDate('created_at', Carbon::today())->distinct('user_id')->count();
        $mostActiveDay = $logsByDay->mapWithKeys(function ($logs, $day) {
            return [$day => $logs->count()];
        })->sortDesc()->keys()->first() ?? 'Aucun';

        // Log for debugging
        Log::debug('Chart data prepared', [
            'days' => $days,
            'loginCounts' => $loginCounts,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'overview' => compact('todayLogins', 'weekLogins', 'uniqueUsers', 'mostActiveDay')
        ]);

        return view('admin.logs', compact(
            'users_logs',
            'actions',
            'loginCounts',
            'startDate',
            'endDate',
            'todayLogins',
            'weekLogins',
            'uniqueUsers',
            'mostActiveDay'
        ));
    }

    public function export(Request $request)
    {
        // Client-side Excel export
        return redirect()->back();
    }
}
