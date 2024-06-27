<?php

declare(strict_types=1);

namespace ShowProject\Bookshelf;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateServiceProvider;
use Orchid\Crud\Arbitrator;
use ShowProject\Bookshelf\Resources\BookshelfResource;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * @param Arbitrator $arbitrator
     * @return void
     */
    public function boot(Arbitrator $arbitrator)
    {
        $arbitrator->resources([
            BookshelfResource::class,
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
