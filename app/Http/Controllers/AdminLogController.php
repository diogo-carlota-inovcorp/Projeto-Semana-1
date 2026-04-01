<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::query();

        $logs = Log::with('user')
            ->when($request->modulo, function($query, $modulo) {
                return $query->where('modulo', $modulo);
            })
            ->when($request->user_id, function($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('data_hora', $date);
            })
            ->orderBy('data_hora', 'desc')
            ->paginate(20);

        $modulos = Log::distinct()->pluck('modulo');

        $logs = $query->orderBy('nome')->paginate(10);

        return view('admin.logs.index', compact('logs', 'modulos'));
    }

    public function show(Log $log)
    {
        return view('admin.logs.show', compact('log'));
    }

    public function destroy(Log $log)
    {
        $log->delete();
        return redirect()->route('admin.logs.index')->with('success', 'Log removido com sucesso!');
    }
}
