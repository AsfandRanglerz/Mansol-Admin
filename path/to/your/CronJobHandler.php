public function handle()
{
    $todayPlusYear = Carbon::now()->addYear()->toDateString();

    // 1. CNIC Expiry - HumanResource
    $cnicHrs = HumanResource::whereDate('cnic_expiry_date', $todayPlusYear)
        ->where('cnic_notified', false)
        ->get();

    if ($cnicHrs->count() > 0) {
        $cnicNotification = Notification::create([
            'type' => 'human_resource',
            'message' => 'Your CNIC will expire in 1 year.',
        ]);

        foreach ($cnicHrs as $hr) {
            $hr->update(['cnic_notified' => true]);

            NotificationTarget::create([
                'notification_id' => $cnicNotification->id,
                'targetable_id' => $hr->id,
                'targetable_type' => \App\Models\HumanResource::class,
            ]);
        }
    }

    // 2. Passport Expiry - HumanResource
    $passportHrs = HumanResource::whereDate('passport_expiry_date', $todayPlusYear)
        ->where('passport_notified', false)
        ->get();

    if ($passportHrs->count() > 0) {
        $passportNotification = Notification::create([
            'type' => 'human_resource',
            'message' => 'Your Passport will expire in 1 year.',
        ]);

        foreach ($passportHrs as $hr) {
            $hr->update(['passport_notified' => true]);

            NotificationTarget::create([
                'notification_id' => $passportNotification->id,
                'targetable_id' => $hr->id,
                'targetable_type' => \App\Models\HumanResource::class,
            ]);
        }
    }

    // 3. Visa Expiry - HrStep
    $visaSteps = HrStep::whereDate('visa_expiry_date', $todayPlusYear)
        ->where('step_number', 6)
        ->where('visa_notified', false)
        ->get();

    if ($visaSteps->count() > 0) {
        $visaNotification = Notification::create([
            'type' => 'human_resource',
            'message' => 'Your Visa will expire in 1 year.',
        ]);

        foreach ($visaSteps as $step) {
            $step->update(['visa_notified' => true]);

            NotificationTarget::create([
                'notification_id' => $visaNotification->id,
                'targetable_id' => $step->id,
                'targetable_type' => \App\Models\HumanResource::class,
            ]);
        }
    }
}
