<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))) {
            abort(403, 'Unauthorized');
        }
        return view('dashboard');
    }

    public function getMonthlyStats(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))) {
            abort(403, 'Unauthorized');
        }
        $start = now()->subMonth()->startOfDay();
        $end = now()->endOfDay();
        $data = DB::table('profit')
            ->whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->get(['date', 'total_sales', 'total_expenses', 'net_profit']);
        return response()->json($data);
    }
} 