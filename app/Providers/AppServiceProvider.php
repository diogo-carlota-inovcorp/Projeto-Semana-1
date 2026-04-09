<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Mensagem;
use App\Observers\MensagemObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('ViewAdicionar', function (User $user) {
            return $user->id == 1;
        });

        Mensagem::observe(MensagemObserver::class);
    }

    public function register(): void
    {
        //
    }
}
