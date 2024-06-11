<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'subscriber_user_id',
        'subscribed_user_id',
        'price',
        'started_at',
        'end_at',
        'show_notification',
        'auto_renew',
        'job_id'
    ];

    public $timestamps = false;

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subscriber_user_id');
    }

    public function subscribedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subscribed_user_id');
    }

    public function isExpired(): bool
    {
        return Carbon::parse($this->end_at)->isPast();
    }
}
