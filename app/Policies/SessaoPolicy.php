<?php

namespace App\Policies;

use App\Models\Sessao;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SessaoPolicy
{
    /**
     * Listar sessões.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Ver detalhes de uma sessão.
     */
    public function view(User $user, Sessao $sessao): bool
    {
        return true;
    }

    /**
     * Criar nova sessão.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Editar / abrir / fechar / gerenciar pauta:
     * permitido para sessões NÃO finalizadas (≠ encerrada/publicada).
     */
    public function update(User $user, Sessao $sessao): Response
    {
        $st = $sessao->normalized_status; // sempre canônico via accessor

        if (!in_array($st, [Sessao::ST_ENCERRADA, Sessao::ST_PUBLICADA], true)) {
            return Response::allow();
        }

        return Response::deny('Sessões finalizadas não podem ser modificadas.');
    }

    /**
     * Excluir sessão:
     * apenas quando planejada e sem itens na pauta.
     */
    public function delete(User $user, Sessao $sessao): bool
    {
        return $sessao->normalized_status === Sessao::ST_PLANEJADA
            && !$sessao->ordemDoDia()->exists();
    }
}
