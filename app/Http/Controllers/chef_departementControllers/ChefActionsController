<?php
namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;


use App\Models\chef_action;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChefActionsController extends Controller
{
    public function index(Request $request)
    {
        $query = chef_action::with('user')->latest();

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
        $actionTypes = chef_action::distinct()->pluck('action_type');

        // Statistics
        $todayActions = chef_action::whereDate('created_at', Carbon::today())->count();
        $weekActions = chef_action::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $uniqueChefs = chef_action::distinct('chef_id')->count('chef_id');
        $mostActiveDay = chef_action::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('count', 'desc')
            ->first();
        $mostActiveDay = $mostActiveDay ? Carbon::parse($mostActiveDay->date)->format('Y-m-d') : 'N/A';

        return view('chef.actions', compact(
            'actions',
            'actionTypes',
            'startDate',
            'endDate',
            'todayActions',
            'weekActions',
            'uniqueChefs',
            'mostActiveDay'
        ));
    }
}
?>