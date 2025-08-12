<?php

namespace App\Policies;

use App\Models\User;

class MenuPolicy
{
    /**
     * Ver se o usuário pode ver (habilitar) o item de menu apontando para uma rota.
     * $routeName deve seguir snake.dot (ex.: 'vereadores.index').
     */
    public function verMenu(User $user, string $routeName): bool
    {
        // TODO: integrar com papéis/perfis quando definirmos
        // Admin vê tudo por padrão; usuários comuns também por enquanto.
        return true;
    }
}
