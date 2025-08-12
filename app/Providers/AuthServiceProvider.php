<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Vereador;
use App\Policies\VereadorPolicy;
use App\Policies\MenuPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Vereador::class => VereadorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para exibir itens de menu conforme habilidade
        Gate::define('menu.ver', [MenuPolicy::class, 'verMenu']);

        // Se preferir sem MenuPolicy, use a versão abaixo e remova a linha acima:
        // Gate::define('menu.ver', fn(\App\Models\User $user, string $ability) => $user->can($ability));
    }
}
