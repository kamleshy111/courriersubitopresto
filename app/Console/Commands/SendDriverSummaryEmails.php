<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Waybill;
use App\Http\Controllers\Admin\DriverController;

class SendDriverReports extends Command
{
    protected $signature = 'driver:send-reports';
    protected $description = 'Send daily driver reports automatically via email';

    public function handle()
    {
        Log::info('Starting driver report cron job');

        // Get all drivers (role = 3)
        // $drivers = User::where('role', 3)->get();
        
        $drivers = User::whereHas('roles', function ($query) {
    $query->where('id', 3);
})->get();

        if ($drivers->isEmpty()) {
            Log::info('No drivers found');
            return Command::SUCCESS;
        }

        foreach ($drivers as $driver) {
            try {
                Log::info('Processing driver: ' . $driver->name);

                // Get today's completed waybills for the driver
                $waybills = Waybill::with(['user.client', 'shipper', 'recipient'])
                    ->where('driver_id', $driver->id)
                    ->where('delivery_status', 1)
                    ->whereDate('drop_time', now()->toDateString())
                    ->get();

                if ($waybills->isEmpty()) {
                    Log::info('No waybills found for driver: ' . $driver->name);
                    continue;
                }

                // Use existing controller logic
                $driverController = new DriverController();
                $data = $driverController->emailPdf($waybills, true, 1, false);

                $pdfContent = $data['pdf'];
                $pdfUrl = config('app.url') . $data['url'];
                $pdfSizeBytes = mb_strlen($pdfContent, '8bit');
                $maxSizeBytes = 20 * 1024 * 1024; // 20MB

                Mail::send([], [], function ($message) use ($pdfContent, $pdfUrl, $pdfSizeBytes, $maxSizeBytes, $driver) {
                    // $message->to('ali2015333061@gmail.com')
                        // ->bcc('widmaertelisma@gmail.com')
                        $message->to('danybergeron@courriersubitopresto.com')
                        ->bcc('ali2015333061@gmail.com')
                        ->subject('Fin de journée du chauffeur: ' . $driver->name);

                    if ($pdfSizeBytes <= $maxSizeBytes) {
                        $message->attachData($pdfContent, 'Waybills.pdf', [
                            'mime' => 'application/pdf',
                        ]);
                        $message->setBody('Fichier PDF joint.', 'text/plain');
                    } else {
                        $message->setBody('Téléchargez le fichier ici : <a href="' . $pdfUrl . '">' . $pdfUrl . '</a>', 'text/html');
                    }
                });

                Log::info('Report emailed successfully for driver: ' . $driver->name);

            } catch (\Exception $e) {
                Log::error('Failed to send report for driver ' . $driver->name . ': ' . $e->getMessage());
            }
        }

        Log::info('All driver reports processed successfully');
        return Command::SUCCESS;
    }
}
