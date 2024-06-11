<?php

use App\Http\Controllers\RenewSubscriptionController;
use Illuminate\Contracts\Queue\ShouldQueue;

if (!function_exists('dispatchId')) {
    function dispatchId(ShouldQueue $job): int
    {
        return RenewSubscriptionController::dispatch($job);
    }
}
