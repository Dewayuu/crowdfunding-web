<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Donation;
use App\Services\MidtransService;

class ExpirePendingDonation extends Command
{
    protected $signature = 'donation:expire';

    protected $description = 'Expire pending donation';

    public function handle()
    {

        $donations = Donation::where(
            'payment_status',
            'pending'
        )
        ->get();

        foreach($donations as $donation){

            try{

                $status = MidtransService::getTransactionStatus(
                    $donation->midtrans_order_id
                );

                if($status->transaction_status=="expire"){

                    $donation->update([

                        'payment_status'=>'expired',

                        'expired_at'=>now()

                    ]);

                }

            }catch(\Throwable $e){

                report($e);

            }

        }

        return Command::SUCCESS;

    }

}