<?php

namespace Irfan\RepositoryMaker;

use Illuminate\Support\ServiceProvider;
use Irfan\RepositoryMaker\Console\Commands\MakeService;
use Irfan\RepositoryMaker\Console\Commands\MakeContract;
use Irfan\RepositoryMaker\Console\Commands\MakeExtendedContract;
use Irfan\RepositoryMaker\Console\Commands\MakeRepository;
use Irfan\RepositoryMaker\Console\Commands\MakeExtendedRepository;
use Irfan\RepositoryMaker\Services\UtilityService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('utility', UtilityService::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeService::class,
                MakeContract::class,
                MakeExtendedContract::class,
                MakeRepository::class,
                MakeExtendedRepository::class,
            ]);
        }
    }
}
