<?php

namespace App\Policies;

use App\Models\Dose;
use App\Models\User;

class DosePolicy
{
    public function view(User $user, Dose $dose): bool
    {
        return $user->id === $dose->user_id;
    }

    public function update(User $user, Dose $dose): bool
    {
        return $user->id === $dose->user_id;
    }
}
