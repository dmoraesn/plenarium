<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Materia;

class MateriaPolicy
{
    // Se quiser liberar tudo para quem está logado
    public function before(User $user, $ability)
    {
        // Ex.: se tiver um is_admin no futuro, podemos checar aqui.
        // if ($user->is_admin) return true;
        return true; // temporário: libera todas as ações
    }

    public function viewAny(User $user): bool   { return true; }
    public function view(User $user, Materia $materia): bool { return true; }
    public function create(User $user): bool    { return true; }
    public function update(User $user, Materia $materia): bool { return true; }
    public function delete(User $user, Materia $materia): bool { return true; }
}
