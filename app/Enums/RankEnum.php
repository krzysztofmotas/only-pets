<?php

namespace App\Enums;

use App\Models\User;
use Illuminate\Support\Carbon;

enum RankEnum: string
{
    case Novice = 'Początkujący';
    case Intermediate = 'Weteran';
    case Advanced = 'Mistrz';

    public function getName(): string
    {
        return $this->value;
    }

    public static function calculateRank(User $user): self
    {
        $registeredAt = $user->created_at;
        $now = Carbon::now();
        $diffInDays = $now->diffInDays($registeredAt);

        if ($diffInDays < 14) {
            return self::Novice;
        } elseif ($diffInDays >= 14 && $diffInDays < 60) {
            return $user->posts()->count() >= 25 ? self::Intermediate : self::Novice;
        } else {
            return $user->posts()->count() >= 50 ? self::Advanced : self::Intermediate;
        }

        // return self::Novice;
        // return self::Advanced;
        // return self::Intermediate;
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Novice => 'Nowy użytkownik',
            self::Intermediate => 'Opublikuj co najmniej 25 postów i bądź członkiem społeczności OnlyPets przynajmniej przez 2 tygodnie.',
            self::Advanced => 'Opublikuj co najmniej 50 postów i bądź członkiem społeczności OnlyPets przynajmniej przez 2 miesiące.',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Novice => 'star',
            self::Intermediate => 'star-half',
            self::Advanced => 'star-fill',
        };
    }

    public function getMaxPostAttachments(): int
    {
        return match ($this) {
            self::Novice => 1,
            self::Intermediate => 3,
            self::Advanced => 6
        };
    }

    public function getSubscriptionDiscount(): int
    {
        return match ($this) {
            self::Novice => 0,
            self::Intermediate => 30,
            self::Advanced => 50,
        };
    }

    public function canAutoRenewSubscription(): bool
    {
        return $this != self::Novice;
        // Tylko użytkownicy posiadający rangę średniozaawansowany i zaawansowany mogą ustawić autoodnawianie subskrypcji.
    }
}
