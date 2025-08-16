<?php

namespace App\Providers;

use App\Models\Sessao;
use App\Models\User;
use App\Policies\SessaoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Map de Models -> Policies.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Sessao::class => \App\Policies\SessaoPolicy::class,
        // Adicione outras policies aqui...
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate genérico para controlar a visibilidade dos itens do menu.
        Gate::define('menu.ver', function (User $user, ?string $abilityName = null) {
            // Em ambiente de desenvolvimento, libera todos os itens do menu.
            if (app()->environment('local')) {
                return true;
            }

            // Em produção, implemente sua lógica real de permissões.
            return true;
        });
    }
}
