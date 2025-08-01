<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Os eventos para os quais os listeners são registrados.
     */
    protected $listen = [
        // Exemplo: \App\Events\EmployeeCreated::class => [\App\Listeners\CreateOnboardingChecklist::class],
        \App\Events\EmployeeCreated::class => [
            \App\Listeners\CreateOnboardingChecklist::class,
        ],
    ];

    /**
     * Registrar quaisquer eventos para o seu aplicativo.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
