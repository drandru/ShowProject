<?php

declare(strict_types=1);

namespace ShowProject\Books;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateServiceProvider;
use Orchid\Crud\Arbitrator;
use ShowProject\Books\Resources\BookResource;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * @param Arbitrator $arbitrator
     * @return void
     */
    public function boot(Arbitrator $arbitrator)
    {
        $arbitrator->resources([
            BookResource::class,
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
