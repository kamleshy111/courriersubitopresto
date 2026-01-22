<?php

namespace App\Console\Commands;

use App\Models\EmailWaybillQueue;
use App\Models\Waybill;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mail;
use Mpdf\Mpdf;

class SendWaybillEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:waybillemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send waybill emails';

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
        $emailsToSend = EmailWaybillQueue::query()->limit(5)->get();

        foreach ($emailsToSend as $emailRequest)
        {
            if($emailRequest->pdf_type == 1)
            {
                $waybill = Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')
                    ->findOrFail($emailRequest->pdf_ids);
                Log::info($waybill);
                $pdf = $this->pdf($waybill,false,1, true);
                Mail::html($emailRequest->content, function ($message) use($emailRequest, $pdf)
                {
                    $message->to($emailRequest->email_to)
                        ->bcc($emailRequest->email_bcc)
                        ->subject($emailRequest->subject . ' : ' .  $emailRequest->user_name)
                        ->attachData($pdf, $emailRequest->attach_data_extension, [
                            'mime' => 'application/pdf',
                        ]);
                });
                $emailRequest->delete();
            }
        }
    }

    public function pdf($waybills, $return = false, $copies = 3, $print = true)
    {
        if($waybills instanceof Waybill)
        {
            $waybills = collect([$waybills]);
            Log::info("way : ". $waybills);
        }

        $pdf = new Mpdf([
            'orientation'   => 'L',
            'margin_left'   => 15/2,
            'margin_right'  => 15/2,
            'margin_top'    => 16/2,
            'margin_bottom' => 16/2,
            'margin_header' => 9/2,
            'margin_footer' => 9/2
        ]);
        $pdf->SetDisplayMode('fullpage');
        $pdf->SetTitle("Waybills (".implode(',', $waybills->pluck('soft_id')->toArray()).")");
        $pdf->shrink_tables_to_fit = 1;


        $lastWaybill = count($waybills)-1;
        foreach($waybills as $k => $waybill) {
            $view = view('admin.waybills.pdf', $waybill)->renderSections();

            for($i = 1; $i <= $copies; $i++) {
                $pdf->SetColumns(2);

                $pdf->WriteHTML($view["col1"]);
                $pdf->AddColumn();
                $pdf->WriteHTML($view["col2"]);

                if(!($i === $copies && $lastWaybill === $k))
                    $pdf->AddPage();
            }
        }

        $pdf->WriteHTML($print);

        return $return ? $pdf->Output('', 'S') : response($pdf->Output('', 'S'))->header('Content-Type', 'application/pdf');
    }
}
