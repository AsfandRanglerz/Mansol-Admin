<?php

namespace App\Jobs;
 
use App\Models\{HumanResource, Company, Project, Demand, MainCraft, SubCraft, Nominate, JobHistory};
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SendHumanResourceWelcomeEmailJob;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class HumanResourceImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function handle(): void
    {
        foreach ($this->rows as $row) {
            try {
                if (!is_array($row)) {
                    Log::error('HumanResourceImportJob row skipped: Row is not an array', ['row' => $row]);
                    continue;
                }
                $row = array_change_key_case($row, CASE_LOWER);

                Log::info('Processing row keys:', array_keys($row));

                // if (empty($row['email']) || !filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                //     Log::warning('Skipping row due to invalid or missing email.', $row);
                //     continue;
                // }

                // if (HumanResource::where('email', $row['email'])->exists()) {
                //     // Skip duplicates
                //     Log::info('Skipping duplicate email: ' . $row['email']);
                //     continue;
                // }

                // Create or get related models
                // if (empty($row['company_name'])) {
                //     Log::warning('Skipping row due to missing company_name.', $row);
                //     continue;
                // }
                $company = Company::where('name', $row['company_name'])->first();
                if (!$company && !empty($row['company_name'])) {
                    Log::warning('Skipping row because company does not exist: ' . $row['company_name'], $row);
                    continue;
                }
                
                $craft = MainCraft::firstOrCreate(['name' => $row['craft_name']]);
                $subCraft = SubCraft::firstOrCreate([
                    'name' => $row['sub_craft_name'] ?? null,
                    'craft_id' => $craft->id,
                ]);
                if($company){
                    // Compute registration/project_code logic safely
                    $lastReg = Project::pluck('project_code')->filter()->map(fn($v) => intval($v))->toArray();
                    $maxValue = !empty($lastReg) ? max($lastReg) : 2000;
                    $registration = $maxValue >= 2000 ? $maxValue + 1 : 2001;
    
                    $project = Project::firstOrCreate(
                        [
                            'project_name' => $row['project_name'],
                            'company_id' => $company->id,
                        ],
                        [
                            'project_code' => $registration,
                        ]
                    );
                    $demand = Demand::firstOrCreate([
                        'project_id' => $project->id,
                        'craft_id' => $craft->id,
                    ]);
                }

                // $password = random_int(10000000, 99999999);
                $password = 12345678; // Default password for new human resources
                // Compute registration number for HumanResource
                $lastReg = HumanResource::pluck('registration')->toArray();
                $filteredValues = array_filter($lastReg, function ($value) {
                    return !is_null($value); // Remove null values
                });
                $integerValues = array_map('intval', $filteredValues);
                $maxValue = !empty($integerValues) ? max($integerValues) : 1000;
                $registration = $maxValue >= 1000 ? $maxValue + 1 : 1001;

                // Convert date fields to Y-m-d format
                $applicationDate = null;
                if (!empty($row['application_date'])) {
                    if (is_numeric($row['application_date'])) {
                        $dt = ExcelDate::excelToDateTimeObject($row['application_date']);
                        $applicationDate = $dt ? $dt->format('Y-m-d') : null;
                    } else {
                        $dt = \DateTime::createFromFormat('d/m/Y', $row['application_date']);
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $row['application_date']);
                        }
                        $applicationDate = $dt ? $dt->format('Y-m-d') : null;
                    }
                }

                $dateOfBirth = null;
                if (!empty($row['date_of_birth'])) {
                    if (is_numeric($row['date_of_birth'])) {
                        $dt = ExcelDate::excelToDateTimeObject($row['date_of_birth']);
                        $dateOfBirth = $dt ? $dt->format('Y-m-d') : null;
                    } else {
                        $dt = \DateTime::createFromFormat('d/m/Y', $row['date_of_birth']);
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $row['date_of_birth']);
                        }
                        $dateOfBirth = $dt ? $dt->format('Y-m-d') : null;
                    }
                }

                $cnicExpiryDate = null;
                if (!empty($row['cnic_expiry_date'])) {
                    if (is_numeric($row['cnic_expiry_date'])) {
                        $dt = ExcelDate::excelToDateTimeObject($row['cnic_expiry_date']);
                        $cnicExpiryDate = $dt ? $dt->format('Y-m-d') : null;
                    } else {
                        $dt = \DateTime::createFromFormat('d/m/Y', $row['cnic_expiry_date']);
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $row['cnic_expiry_date']);
                        }
                        $cnicExpiryDate = $dt ? $dt->format('Y-m-d') : null;
                    }
                }

                
                $doi = null;
                if (!empty($row['doi'])) {
                    if (is_numeric($row['doi'])) {
                        $dt = ExcelDate::excelToDateTimeObject($row['doi']);
                        $doi = $dt ? $dt->format('Y-m-d') : null;
                    } else {
                        $dt = \DateTime::createFromFormat('d/m/Y', $row['doi']);
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $row['doi']);
                        }
                        $doi = $dt ? $dt->format('Y-m-d') : null;
                    }
                }


                
                $doe = null;
                if (!empty($row['doe'])) {
                    if (is_numeric($row['doe'])) {
                        $dt = ExcelDate::excelToDateTimeObject($row['doe']);
                        $doe = $dt ? $dt->format('Y-m-d') : null;
                    } else {
                        $dt = \DateTime::createFromFormat('d/m/Y', $row['doe']);
                        if (!$dt) {
                            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $row['doe']);
                        }
                        $doe = $dt ? $dt->format('Y-m-d') : null;
                    }
                }

                $hr = HumanResource::create([
                    'name' => $row['name'] ?? '',
                    'email' => $row['email'],
                    'approvals' => strtolower($row['approvals'] ?? null),
                    'password' => bcrypt($password),
                    // 'status' => $row['status'] ?? null,
                    'registration' => $registration ?? null,
                    'application_date' => $applicationDate,
                    'experience_local' => $row['experience_local'] ?? null,
                    'experience_gulf' => $row['experience_gulf'] ?? null,
                    'son_of' => $row['son_of'] ?? null,
                    'mother_name' => $row['mother_name'] ?? null,
                    'blood_group' => strtolower($row['blood_group'] ?? null),
                    'date_of_birth' => $dateOfBirth,
                    'city_of_birth' => $row['city_of_birth'] ?? null,
                    'city_of_interview' => $row['city_of_interview'] ?? null,
                    'cnic' => $row['cnic'] ?? null,
                    'cnic_expiry_date' => $cnicExpiryDate,
                    'doi' => $doi,
                    'doe' => $doe,
                    'passport' => $row['passport'] ?? null,
                    'passport_issue_place' => strtolower($row['passport_issue_place'] ?? null),
                    'religion' => strtolower($row['religion'] ?? null),
                    'martial_status' => strtolower($row['martial_status'] ?? null),
                    'next_of_kin' => $row['next_of_kin'] ?? null,
                    'relation' => strtolower($row['relation'] ?? null),
                    'kin_cnic' => $row['kin_cnic'] ?? null,
                    'shoe_size' => strtolower($row['shoe_size'] ?? null),
                    'cover_size' => $row['cover_size'] ?? null,
                    'acdemic_qualification' => strtolower($row['acdemic_qualification'] ?? null),
                    'technical_qualification' => $row['technical_qualification'] ?? null,
                    'district_of_domicile' => $row['district_of_domicile'] ?? null,
                    'present_address' => $row['present_address'] ?? null,
                    'present_address_phone' => $row['present_address_phone'] ?? null,
                    'present_address_mobile' => $row['present_address_mobile'] ?? null,
                    'present_address_city' => strtolower($row['present_address_city'] ?? null),
                    'permanent_address' => $row['permanent_address'] ?? null,
                    'permanent_address_phone' => $row['permanent_address_phone'] ?? null,
                    'permanent_address_mobile' => $row['permanent_address_mobile'] ?? null,
                    'permanent_address_city' => strtolower($row['permanent_address_city'] ?? null),
                    'permanent_address_province' => $row['permanent_address_province'] ?? null,
                    'gender' => strtolower($row['gender'] ?? null),
                    'citizenship' => $row['citizenship'] ?? null,
                    'refference' => $row['refference'] ?? null,
                    'performance_appraisal' => $row['performance_appraisal'] ?? null,
                    'min_salary' => $row['min_salary'] ?? null,
                    'comment' => $row['comment'] ?? null,
                    'image' => 'public/admin/assets/images/users/avatar.png',
                    'currancy' => $row['currancy'] ?? null,
                    'craft_id' => $craft->id,
                    'sub_craft_id' => $subCraft->id,
                    'city_of_interview' => strtolower($row['city_of_interview'] ?? null),
                ]);

                if (!empty($company->id)) {
                    Nominate::create([
                        'craft_id' => $craft->id,
                        'human_resource_id' => $hr->id,
                        'demand_id' => $demand->id,
                        'project_id' => $project->id,
                    ]);

                    JobHistory::create([
                        'human_resource_id' => $hr->id,
                        'company_id' => $company->id,
                        'project_id' => $project->id,
                        'demand_id' => $demand->id,
                        'craft_id' => $craft->id,
                        'sub_craft_id' => $subCraft->id,
                        'application_date' => $row['application_date'] ?? null,
                        'city_of_interview' => $row['city_of_interview'] ?? null,
                    ]);
                }

                // Queue the welcome email
                // SendHumanResourceWelcomeEmailJob::dispatch($row['email'], $password);

            } catch (\Throwable $e) {
                Log::error('HumanResourceImportJob row failed: ' . $e->getMessage(), ['row' => $row]);
                // Continue to next row
            }
        }
    }
}
