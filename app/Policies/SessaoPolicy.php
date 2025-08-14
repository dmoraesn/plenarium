<?php

namespace App\Policies;

use App\Models\Sessao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a lista de sessões.
     */
    public function viewAny(User $user)
    {
        // Qualquer usuário logado pode ver a lista.
        return true;
    }

    /**
     * Determina se o usuário pode criar uma nova sessão.
     */
    public function create(User $user)
    {
        // Exemplo: qualquer usuário logado pode criar. Ajuste se necessário.
        return true;
    }

    /**
     * Determina se o usuário pode atualizar a sessão.
     * CORREÇÃO: Compara com a string 'planejada' em vez de um Enum.
     */
    public function update(User $user, Sessao $sessao)
    {
        // Regra: Só pode editar se a sessão estiver no estado 'planejada'.
        return $sessao->status === 'planejada';
    }

    /**
     * Determina se o usuário pode excluir a sessão.
     * CORREÇÃO: Compara com a string 'planejada' em vez de um Enum.
     */
    public function delete(User $user, Sessao $sessao)
    {
        // Regra: Só pode excluir se estiver 'planejada' e não tiver itens na pauta.
        return $sessao->status === 'planejada' && !$sessao->ordemDoDia()->exists();
    }
}
