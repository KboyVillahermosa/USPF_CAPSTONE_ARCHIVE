<?php

namespace App\Http\Controllers;

use App\Models\DownloadLog;
use App\Models\ResearchRepository;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller 
{
    public function index()
    {
        return view('admin.index');
    }

    public function downloadStats()
    {
        // Get purpose statistics
        $purposeStats = DownloadLog::select('purposes')
            ->get()
            ->flatMap(function ($log) {
                return json_decode($log->purposes);
            })
            ->countBy()
            ->toArray();

        // Get downloads per research
        $researchStats = DownloadLog::select('research_id', DB::raw('count(*) as download_count'))
            ->groupBy('research_id')
            ->with('research:id,project_name')
            ->orderByDesc('download_count')
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->research->project_name => $item->download_count];
            })
            ->toArray();

        return view('admin.download-stats', [
            'purposeLabels' => array_keys($purposeStats),
            'purposeData' => array_values($purposeStats),
            'researchLabels' => array_keys($researchStats),
            'researchData' => array_values($researchStats)
        ]);
    }
}