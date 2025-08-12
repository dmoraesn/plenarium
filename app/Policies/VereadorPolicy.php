<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vereador;

class VereadorPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Vereador $v): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, Vereador $v): bool { return true; }
    public function delete(User $user, Vereador $v): bool { return true; }
}
