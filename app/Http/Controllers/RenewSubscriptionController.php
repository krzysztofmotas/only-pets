<?php

namespace App\Http\Controllers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;

// https://github.com/arispati/laravel-dispatch-id
class RenewSubscriptionController extends Controller
{
    public static function dispatch(ShouldQueue $job): int
    {
        return static::dispatcher()->dispatch($job);
    }

    private static function dispatcher()
    {
        return Container::getInstance()->make(Dispatcher::class);
    }
}
