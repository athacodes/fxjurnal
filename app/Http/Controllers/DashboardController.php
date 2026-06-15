<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $role = strtolower($user->role);

        if ($role === 'admin') {
            $totalMembers = DB::table('users')->where('role', 'member')->count();
            $totalJournals = DB::table('notes')->count();
            $totalSignals = DB::table('signals')->count();

            $latestJournals = DB::table('notes')
                ->join('users', 'notes.user_id', '=', 'users.id')
                ->select('notes.*', 'users.username')
                ->orderBy('notes.created_at', 'desc')
                ->limit(5)
                ->get();

            return view('pages.admin.dashboard', compact('totalMembers', 'totalJournals', 'totalSignals', 'latestJournals'));
        }

        $filter = $request->query('filter', 'all');

        $query = DB::table('notes')->where('user_id', $userId);

        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'monthly') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter === 'yearly') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $filteredNotes = $query->orderBy('created_at', 'desc')->get();

        $totalTrades = $filteredNotes->count();

        return view('pages.dashboard', compact('filteredNotes', 'totalTrades', 'filter'));
    }
}