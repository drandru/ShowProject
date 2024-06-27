<?php

declare(strict_types=1);

namespace ShowProject\Authors;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateServiceProvider;
use Orchid\Crud\Arbitrator;
use ShowProject\Authors\Resources\AuthorResource;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * @param Arbitrator $arbitrator
     * @return void
     */
    public function boot(Arbitrator $arbitrator)
    {
        $arbitrator->resources([
            AuthorResource::class,
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
