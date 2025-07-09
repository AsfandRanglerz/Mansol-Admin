<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\HumanResourceImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class BulkFeatureController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
 
        try {
            Log::info('Starting Excel import.');
            $start = now();
            Log::info("Import started at: $start");
            Excel::import(new HumanResourceImport, $request->file('file'));
            Log::info('Excel import completed successfully.');
            $end = now();
            Log::info("Import dispatched at: $end");

            return back()->with('message', 'Excel file Imported Successfully. The data is now being processed — it may take a while to complete');
        } catch (\Throwable $e) {
            Log::error('Import failed: ' . $e->getMessage());

            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
