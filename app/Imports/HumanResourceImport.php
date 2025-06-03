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

class HumanResourceImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation
{
    /**
     * This method is called for each chunk of rows (size defined in chunkSize()).
     *
     * @param  Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalize keys: trim & lowercase for safety
            $cleanRow = [];
            foreach ($row->toArray() as $key => $value) {
                $cleanKey = trim(strtolower($key));
                $cleanRow[$cleanKey] = $value;
            }

            Log::info('Dispatching row:', $cleanRow);

            HumanResourceImportJob::dispatch($cleanRow);
        }
    }

    /**
     * Defines how many rows each queued job will process.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;   // e.g., 1,000 rows per job
    }

    /**
     * Validation rules for each row.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.email' => 'required|email',
            '*.name' => 'required|string',
            '*.company_name' => 'required|string',
            '*.project_name' => 'required|string',
            '*.craft_name' => 'required|string',
            '*.sub_craft_name' => 'nullable|string',
            // Add more validation as needed for your columns
        ];
    }
}
