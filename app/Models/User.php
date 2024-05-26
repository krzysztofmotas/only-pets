<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'email',
        'password',
        'bio',
        'location',
        'website_url',
        'avatar',
        'background',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function generateUniqueName($displayName)
    {
        $cleanName = preg_replace('/[^\p{L}\p{N}\s]/u', '', $displayName); // bez emoji
        $name = strtolower(str_replace(' ', '', $cleanName));

        $originalName = $name;
        $counter = 1;

        while (self::where('name', $name)->exists()) {
            $counter++;
            $name = $originalName . $counter;
        }

        return $name;
    }

    public function isAdmin(): bool
    {
        return $this->role_id == User::ROLE_ADMIN;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'subscriber_user_id');
    }

    public function subscribedBy(): HasMany
    {
        return $this->hasMany(Subscription::class, 'subscribed_user_id');
    }

    function getInitials(): string
    {
        $cleanName = preg_replace('/[^\p{L}\p{N}\s]/u', '', $this->display_name); // bez emoji

        $nameParts = explode(' ', $cleanName);
        $initials = '';

        if (count($nameParts) > 1) {
            foreach ($nameParts as $part) {
                $initials .= strtoupper(substr($part, 0, 1));

                if (strlen($initials) >= 2) {
                    break;
                }
            }
        } else {
            $initials = strtoupper(substr($cleanName, 0, 2));
        }

        return $initials;
    }

    public static function getSuggestedUsers($limit = 3)
    {
        return self::inRandomOrder()->limit($limit)->get();
    }

    public function hasActiveSubscriptionFor($id): bool
    {
        return $this->subscriptions()
            ->where('subscribed_user_id', $id)
            ->where('end_at', '>', now())
            ->exists();
    }

    public function hasActiveSubscriptionFrom($id): bool
    {
        return $this->subscribedBy()
            ->where('subscriber_user_id', $id)
            ->where('end_at', '>', now())
            ->exists();
    }

    public function getSubscriptionForUser($id): ?Subscription
    {
        return $this->subscriptions()
            ->where('subscribed_user_id', $id)
            ->where('end_at', '>', now())
            ->first();
    }

    public function notificationsCount()
    {
        $oneWeekFromNow = Carbon::now()->addWeek();

        return $this->subscriptions()
            ->where('show_notification', true)
            ->where('end_at', '<=', $oneWeekFromNow)
            ->count();
    }
}
