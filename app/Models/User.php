<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

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
        $name = strtolower(str_replace(' ', '', $displayName));

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

    function getInitials(): string
    {
        $nameParts = explode(' ', $this->display_name);
        $initials = '';

        if (count($nameParts) > 1) {
            foreach ($nameParts as $part) {
                $initials .= strtoupper(substr($part, 0, 1));

                if (strlen($initials) >= 2) {
                    break;
                }
            }
        } else {
            $initials = strtoupper(substr($this->display_name, 0, 2));
        }
        return $initials;
    }

    public static function getSuggestedUsers($limit = 3) {
        return self::inRandomOrder()->limit($limit)->get();
    }
}
