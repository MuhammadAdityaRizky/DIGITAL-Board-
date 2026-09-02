<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function status($id)
    {
        $status = \Illuminate\Support\Facades\Cache::get('import_status_' . $id, 'unknown');
        $total = (int) \Illuminate\Support\Facades\Cache::get('import_total_' . $id, 0);
        $progress = (int) \Illuminate\Support\Facades\Cache::get('import_progress_' . $id, 0);

        $percentage = $total > 0 ? min(100, round(($progress / $total) * 100)) : 0;

        return response()->json([
            'status' => $status,
            'total' => $total,
            'progress' => $progress,
            'percentage' => $percentage
        ]);
    }
}
