<?php

namespace App\Imports;

use App\Jobs\HumanResourceImportJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class HumanResourceImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation,WithCalculatedFormulas 
{
    /**
     * Defines how many rows each queued job will process.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 500;   // e.g., 1,000 rows per job
    }
    /**
     * This method is called for each chunk of rows (size defined in chunkSize()).
     *
     * @param  Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $cleanRows = [];
        $cnicList = [];
        foreach ($rows as $row) {
            if (!is_array($row) && method_exists($row, 'toArray')) {
                $row = $row->toArray();
            }
            if (!is_array($row)) {
                Log::error('Import row skipped: Row is not an array', ['row' => $row]);
                continue;
            }
            $cleanRow = [];
            foreach ($row as $key => $value) {
                $cleanKey = trim(strtolower($key));
                $cleanRow[$cleanKey] = $value;
            }
            // Collect CNIC if exists
            if (isset($cleanRow['cnic'])) {
                $cnicList[] = trim($cleanRow['cnic']);
            }
            $cleanRows[] = $cleanRow;
        }
        // Check for duplicate CNICs
        $duplicates = array_unique(
            array_diff_assoc($cnicList, array_unique($cnicList))
        );
       if (!empty($duplicates)) {

        // Convert duplicates to a readable string
        $duplicateList = implode(', ', $duplicates);

        // ❌ Stop the import and return JSON error message
        throw new \Exception("Duplicate CNIC found in Excel: $duplicateList");
     } 

        if (!empty($cleanRows)) {
            Log::info('Dispatching batch of rows', ['count' => count($cleanRows)]);
            HumanResourceImportJob::dispatch($cleanRows);
        }
    }


    /**
     * Validation rules for each row.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
        ];
    }
}
