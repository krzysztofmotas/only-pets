<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'subscriber_user_id',
        'subscribed_user_id',
        'cost',
        'end_at',
        'payment_method',
        'payment_currency',
        'is_active',
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
}
