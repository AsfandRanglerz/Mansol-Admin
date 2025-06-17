<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HumanResource;
use App\Notifications\ExpiryNotification;
use Carbon\Carbon;

class NotifyExpiringDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $todayPlusYear = Carbon::now()->addYear()->toDateString();

        $hrs = HumanResource::all();

        foreach ($hrs as $hr) {
            // CNIC
            if ($hr->cnic_expiry_date == $todayPlusYear && !$hr->cnic_notified) {
                $hr->notify(new ExpiryNotification('CNIC Expiry', 'Your CNIC will expire in 1 year.'));
                $hr->update(['cnic_notified' => true]);
            }

            // Passport
            if ($hr->passport_expiry_date == $todayPlusYear && !$hr->passport_notified) {
                $hr->notify(new ExpiryNotification('Passport Expiry', 'Your Passport will expire in 1 year.'));
                $hr->update(['passport_notified' => true]);
            }

            // Visa
            if ($hr->visa_expiry_date == $todayPlusYear && !$hr->visa_notified) {
                $hr->notify(new ExpiryNotification('Visa Expiry', 'Your Visa will expire in 1 year.'));
                $hr->update(['visa_notified' => true]);
            }
        }
    }
}
