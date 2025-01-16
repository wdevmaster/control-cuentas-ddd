<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Bank\Account\Domain\Repositories\AccountRepository;
use Bank\Account\Infrastructure\Persistence\Eloquent\EloquentAccountRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
    }
}
