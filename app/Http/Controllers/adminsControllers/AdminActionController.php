<?php
/////

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;


use App\Models\admin_action;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminActionController extends Controller
{
    public function index(Request $request)
    {
        $query = admin_action::with('user')->latest();

        // Filters
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->whereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($action = $request->input('action')) {
            $query->where('action_type', $action);
        }

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfWeek();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfWeek();
        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Paginated results
        $actions = $query->paginate(10);

        // Distinct action types for filter dropdown
        $actionTypes = admin_action::distinct()->pluck('action_type');

        // Statistics
        $todayActions = admin_action::whereDate('created_at', Carbon::today())->count();
        $weekActions = admin_action::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $uniqueAdmins = admin_action::distinct('admin_id')->count('admin_id'); // Changed from user_id to admin_id
        $mostActiveDay = admin_action::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('count', 'desc')
            ->first();
        $mostActiveDay = $mostActiveDay ? Carbon::parse($mostActiveDay->date)->format('Y-m-d') : 'N/A';

        return view('admin.actions', compact(
            'actions',
            'actionTypes',
            'startDate',
            'endDate',
            'todayActions',
            'weekActions',
            'uniqueAdmins',
            'mostActiveDay'
        ));
    }
}
?>