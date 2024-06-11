<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Subscription;

class RenewSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Subscription $subscription)
    {
    }

    public function handle(): void
    {
        $subscription = $this->subscription;

        // aktualny job za chwilkę zostanie usunięty, więc subskrypcja musi "rozłączyć" job_id,
        // ze względu na ograniczenia klucza obcego.

        $subscription->job_id = null;
        $subscription->save();

        $subscriber = $subscription->subscriber;
        if ($subscription->auto_renew && $subscriber->getRank()->canAutoRenewSubscription()) {
            $price = env('SUBSCRIPTION_MONTH_PRICE') * 1;

            $discount = $subscriber->getRank()->getSubscriptionDiscount();
            if ($discount > 0) {
                $discountedPrice = $price - ($price * ($discount / 100));
                $price = $discountedPrice;
            }

            $endDateTime = Carbon::now()->addMonth(1);
            // $endDateTime = Carbon::now()->addSecond(10);

            $subscription->end_at = $endDateTime->toDateTime();
            $diffInSeconds = now()->diffInSeconds($endDateTime);

            $job = (new RenewSubscriptionJob($subscription))->delay(now()->addSeconds($diffInSeconds));
            $jobId = dispatchId($job);

            $subscription->job_id = $jobId;
            $subscription->price = $price;
            $subscription->save();
        }

        // w przeciwnym wypadku subskrypcja nie zostanie przedłużona i wygaśnie
    }
}
