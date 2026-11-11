<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan log aktivitas sistem (Audit Trail Log).
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter Pencarian (Mencari di kolom action atau nama user)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Berdasarkan Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('owner.logs.index', compact('logs'));
    }
}