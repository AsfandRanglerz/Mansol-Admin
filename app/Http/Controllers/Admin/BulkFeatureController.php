<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\HumanResourceImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BulkFeatureController extends Controller
{
    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv',
    //     ]);
 
    //     try {
    //         Log::info('Starting Excel import.');
    //         $start = now();
    //         Log::info("Import started at: $start");
    //         Excel::import(new HumanResourceImport, $request->file('file'));
    //         Log::info('Excel import completed successfully.');
    //         $end = now();
    //         Log::info("Import dispatched at: $end");

    //         return back()->with('message', 'Excel file Imported Successfully. The data is now being processed — it may take a while to complete');
    //     } catch (\Throwable $e) {
    //         Log::error('Import failed: ' . $e->getMessage());

    //         return back()->with('error', 'Import failed: ' . $e->getMessage());
    //     }
    // }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Log::info('Starting Excel import.');
            $start = now();
            Log::info("Import started at: $start");
                $expectedHeaders = [
                    'NAME',
                    'SON_OF',
                    'CNIC',
                    'RELIGION',
                    'EXPERIENCE_GULF',
                    'MARTIAL_STATUS',
                    'ACADEMIC_QUALIFICATION',
                    'TECHNICAL_QUALIFICATION',
                    'GENDER',
                    'CITIZENSHIP',
                ];
 
                $spreadsheet = IOFactory::load($request->file('file')->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                // Get the calculated values, not formulas
                $headerRow = [];
                foreach ($worksheet->getColumnIterator() as $column) {
                    $cell = $worksheet->getCell($column->getColumnIndex() . '1');
                    $value = $cell->getCalculatedValue(); // ✅ This ensures formulas are evaluated
                    $headerRow[] = strtoupper(trim((string)$value)); // ✅ Normalize
                }

                // Normalize expected headers too
                $expectedHeaders = array_map('strtoupper', $expectedHeaders);

                // Compare
                $missingHeaders = array_diff($expectedHeaders, $headerRow);

                if (!empty($missingHeaders)) {
                    $errorMsg = 'Missing Required Columns: ' . implode(', ', $missingHeaders);
                    Log::error($errorMsg);

                    if ($request->ajax()) {
                        return response()->json(['message' => $errorMsg], 422);
                    }
                    return back()->with('error', $errorMsg);
                }
               $cnicColumnIndex = array_search('CNIC', $headerRow);

            if ($cnicColumnIndex === false) {
                throw new \Exception("CNIC column not found.");
            }

            // Convert index → Excel letter (0 = A, 1 = B, 2 = C ...)
            $cnicColumnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cnicColumnIndex + 1);

            $cnicList = [];

            foreach ($worksheet->getRowIterator(2) as $row) {
                $rowIndex = $row->getRowIndex();
                $cell = $worksheet->getCell($cnicColumnLetter . $rowIndex);

                $cnic = trim((string)$cell->getCalculatedValue());

                if ($cnic !== '') {
                    $cnicList[] = $cnic;
                }
            }


        $duplicates = array_unique(array_diff_assoc($cnicList, array_unique($cnicList)));

        if (!empty($duplicates)) {

            $message = "Duplicate CNIC found ";

            Log::error($message);

            if ($request->ajax()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->with('error', $message);
        }
            Excel::queueImport(new HumanResourceImport, $request->file('file'));
            $end = now();
            Log::info("Import completed at: $end");

            if ($request->ajax()) {
                return response()->json(['message' => 'Excel file imported successfully. The data is now being processed.']);
            }

            return back()->with('message', 'Excel file imported successfully. The data is now being processed.');
        } catch (\Throwable $e) {
            Log::error('Import failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['message' => 'Import failed: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
 
}
