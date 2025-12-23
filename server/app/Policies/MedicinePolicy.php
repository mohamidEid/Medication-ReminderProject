<?php

namespace App\Policies;

use App\Models\Medicine;
use App\Models\User;

class MedicinePolicy
{
    public function view(User $user, Medicine $medicine): bool
    {
        return $user->id === $medicine->user_id;
    }

    public function update(User $user, Medicine $medicine): bool
    {
        return $user->id === $medicine->user_id;
    }

    public function delete(User $user, Medicine $medicine): bool
    {
        return $user->id === $medicine->user_id;
    }
}
