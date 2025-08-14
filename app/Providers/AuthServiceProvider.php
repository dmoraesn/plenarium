<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Importe os models e policies
use App\Models\Sessao;
use App\Policies\SessaoPolicy;
use App\Models\Materia;
use App\Policies\MateriaPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Adicione esta linha:
        Sessao::class => SessaoPolicy::class,
        Materia::class => MateriaPolicy::class, // Exemplo de outra policy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}