<?php

namespace App\Jobs;

use App\Models\{HumanResource, Company, Project, Demand, Craft, SubCraft, Nominate, JobHistory};
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SendHumanResourceWelcomeEmailJob;

class HumanResourceImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function handle(): void
    {
        try {
            $row = array_change_key_case($this->row, CASE_LOWER);

            Log::info('Processing row keys:', array_keys($row));

            if (empty($row['email']) || !filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                Log::warning('Skipping row due to invalid or missing email.', $row);
                return;
            }

            if (HumanResource::where('email', $row['email'])->exists()) {
                // Skip duplicates
                Log::info('Skipping duplicate email: ' . $row['email']);
                return;
            }

            // Create or get related models
            $company = Company::firstOrCreate(['name' => $row['company_name']]);
            
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

            $craft = Craft::firstOrCreate(['name' => $row['craft_name']]);
            $subCraft = SubCraft::firstOrCreate([
                'name' => $row['sub_craft_name'] ?? null,
                'craft_id' => $craft->id,
            ]);
            $demand = Demand::firstOrCreate([
                'company_id' => $company->id,
                'project_id' => $project->id,
                'craft_id' => $craft->id,
            ]);

            $password = random_int(10000000, 99999999);

            $hr = HumanResource::create([
                'name' => $row['name'] ?? '',
                'email' => $row['email'],
                'password' => bcrypt($password),
                'status' => $row['status'] ?? null,
                'registration' => $row['registration'] ?? null,
                'application_date' => $row['application_date'] ?? null,
                'experience_local' => $row['experience_local'] ?? null,
                'experience_gulf' => $row['experience_gulf'] ?? null,
                'son_of' => $row['son_of'] ?? null,
                'mother_name' => $row['mother_name'] ?? null,
                'blood_group' => $row['blood_group'] ?? null,
                'date_of_birth' => $row['date_of_birth'] ?? null,
                'city_of_birth' => $row['city_of_birth'] ?? null,
                'city_of_interview' => $row['city_of_interview'] ?? null,
                'cnic' => $row['cnic'] ?? null,
                'cnic_expiry_date' => $row['cnic_expiry_date'] ?? null,
                'doi' => $row['doi'] ?? null,
                'doe' => $row['doe'] ?? null,
                'passport' => $row['passport'] ?? null,
                'passport_issue_place' => $row['passport_issue_place'] ?? null,
                'religion' => $row['religion'] ?? null,
                'martial_status' => $row['martial_status'] ?? null,
                'next_of_kin' => $row['next_of_kin'] ?? null,
                'relation' => $row['relation'] ?? null,
                'kin_cnic' => $row['kin_cnic'] ?? null,
                'shoe_size' => $row['shoe_size'] ?? null,
                'cover_size' => $row['cover_size'] ?? null,
                'acdemic_qualification' => $row['acdemic_qualification'] ?? null,
                'technical_qualification' => $row['technical_qualification'] ?? null,
                'district_of_domicile' => $row['district_of_domicile'] ?? null,
                'present_address' => $row['present_address'] ?? null,
                'present_address_phone' => $row['present_address_phone'] ?? null,
                'present_address_mobile' => $row['present_address_mobile'] ?? null,
                'present_address_city' => $row['present_address_city'] ?? null,
                'permanent_address' => $row['permanent_address'] ?? null,
                'permanent_address_phone' => $row['permanent_address_phone'] ?? null,
                'permanent_address_mobile' => $row['permanent_address_mobile'] ?? null,
                'permanent_address_city' => $row['permanent_address_city'] ?? null,
                'permanent_address_province' => $row['permanent_address_province'] ?? null,
                'gender' => $row['gender'] ?? null,
                'citizenship' => $row['citizenship'] ?? null,
                'refference' => $row['refference'] ?? null,
                'performance_appraisal' => $row['performance_appraisal'] ?? null,
                'min_salary' => $row['min_salary'] ?? null,
                'comment' => $row['comment'] ?? null,
                'image' => 'public/admin/assets/images/users/avatar.png',
                'craft_id' => $craft->id,
                'sub_craft_id' => $subCraft->id,
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
            SendHumanResourceWelcomeEmailJob::dispatch($row['email'], $password);
        } catch (\Throwable $e) {
            Log::error('HumanResourceImportJob failed: ' . $e->getMessage(), ['row' => $this->row]);
        }
    }
}
