<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\HumanResource;
use App\Models\HrStep;
use App\Models\Notification;
use App\Models\NotificationTarget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class DocumentExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:expiration-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users about visa,cnic and passport expiration before one year of expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // { 
    //     $todayPlusYear = Carbon::now()->addYear()->toDateString();
    //     // === 1. CNIC Expiry - HumanResource ===
    //     $cnicHrs = HumanResource::whereDate('cnic_expiry_date', $todayPlusYear)
    //     ->get();
       
    //     if ($cnicHrs->isNotEmpty()) {
            
    //         foreach ($cnicHrs as $hr) {
    //             $hr->update(['cnic_notified' => true]);
                
    //             $cnicNotification = Notification::create([
    // 'type' => 'human_resource',                
    // 'document_type' => 'CNIC',
    //                 'date'=>$hr->cnic_expiry_date,
    //                 'message' => $hr->name.' your CNIC will expire in 1 year.',
    //             ]);
    //         NotificationTarget::create([
    //             'notification_id' => $cnicNotification->id,
    //             'targetable_id' => $hr->id,
    //             'targetable_type' => \App\Models\HumanResource::class,
    //         ]);
    //     }
    //     }
    //     // === 2. Passport Expiry - HumanResource ===
    //     $passportHrs = HumanResource::whereDate('doe', $todayPlusYear)
    //     ->get();

    //     if ($passportHrs->isNotEmpty()) {
            
    //         foreach ($passportHrs as $hr) {
    //             $hr->update(['passport_notified' => true]);
    //             $passportNotification = Notification::create([
    // 'type' => 'human_resource',                
    // 'document_type' => 'Passport',
    //                 'date'=>$hr->doe,
    //                 'message' => $hr->name.' your passport will expire in 1 year.',
    //             ]);

    //         NotificationTarget::create([
    //             'notification_id' => $passportNotification->id,
    //             'targetable_id' => $hr->id,
    //             'targetable_type' => \App\Models\HumanResource::class,
    //         ]);
    //     }
    //     }
    //     // === 3. Visa Expiry - HrStep ===
    //     $visaSteps = HrStep::whereDate('visa_expiry_date', $todayPlusYear)
    //     ->where('step_number', 6)
    //     ->get();

    //     if ($visaSteps->isNotEmpty()) {
            
    //         foreach ($visaSteps as $step) {
                
    //             $visaNotification = Notification::create([
    // 'type' => 'human_resource',                
    // 'document_type' => 'Visa',
    //                 'date'=>$step->visa_expiry_date,
    //                 'message' => $hr->name.' your Visa will expire in 1 year.',
    //             ]);
    //         NotificationTarget::create([
    //             'notification_id' => $visaNotification->id,
    //             'targetable_id' => $step->human_resource_id, // Assuming this is the
    //             'targetable_type' => \App\Models\HumanResource::class, // Keep this as HumanResource if that’s intentional
    //         ]);
    //     }
    //     }
    // }

    public function handle()
{
    Log::info('Running DocumentExpirationNotification command');

    try {
        $todayPlusYear = Carbon::now()->addYear()->toDateString();

        // === 1. CNIC Expiry - HumanResource ===
        $cnicHrs = HumanResource::whereDate('cnic_expiry_date', $todayPlusYear)->get();

        if ($cnicHrs->isNotEmpty()) {
            foreach ($cnicHrs as $hr) {
                // $hr->update(['cnic_notified' => true]);

                $cnicNotification = Notification::create([
                    'type' => 'human_resource',
                    'document_type' => 'CNIC',
                    'date' => $hr->cnic_expiry_date,
                    'message' => "{$hr->name} your CNIC will expire in 1 year.",
                ]);

                NotificationTarget::create([
                    'notification_id' => $cnicNotification->id,
                    'targetable_id' => $hr->id,
                    'targetable_type' => \App\Models\HumanResource::class,
                ]);

                Log::info("CNIC notification created for HR ID {$hr->id}");
            }
        }

        // === 2. Passport Expiry - HumanResource ===
        $passportHrs = HumanResource::whereDate('doe', $todayPlusYear)->get();

        if ($passportHrs->isNotEmpty()) {
            foreach ($passportHrs as $hr) {
                // $hr->update(['passport_notified' => true]);

                $passportNotification = Notification::create([
                    'type' => 'human_resource',
                    'document_type' => 'Passport',
                    'date' => $hr->doe,
                    'message' => "{$hr->name} your passport will expire in 1 year.",
                ]);

                NotificationTarget::create([
                    'notification_id' => $passportNotification->id,
                    'targetable_id' => $hr->id,
                    'targetable_type' => \App\Models\HumanResource::class,
                ]);

                Log::info("Passport notification created for HR ID {$hr->id}");
            }
        }

        // === 3. Visa Expiry - HrStep ===
        $visaSteps = HrStep::whereDate('visa_expiry_date', $todayPlusYear)
            ->where('step_number', 6)
            ->get();

        if ($visaSteps->isNotEmpty()) {
            foreach ($visaSteps as $step) {
                $hr = $step->humanResource; // assuming you have relation defined
                $visaNotification = Notification::create([
                    'type' => 'human_resource',
                    'document_type' => 'Visa',
                    'date' => $step->visa_expiry_date,
                    'message' => "{$hr->name} your Visa will expire in 1 year.",
                ]);

                NotificationTarget::create([
                    'notification_id' => $visaNotification->id,
                    'targetable_id' => $step->human_resource_id,
                    'targetable_type' => \App\Models\HumanResource::class,
                ]);

                Log::info("Visa notification created for HR ID {$step->human_resource_id}");
            }
        }

        Log::info('DocumentExpirationNotification command completed successfully.');

    } catch (\Throwable $e) {
        Log::error('Error in DocumentExpirationNotification command: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
    }
}
}
