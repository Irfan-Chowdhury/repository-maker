<?php

namespace Irfan\RepositoryMaker;

use Illuminate\Support\ServiceProvider;
use Irfan\RepositoryMaker\Console\Commands\MakeBaseContract;
use Irfan\RepositoryMaker\Console\Commands\MakeBaseRepository;
use Irfan\RepositoryMaker\Console\Commands\MakeContract;
use Irfan\RepositoryMaker\Console\Commands\MakeExtendedContract;
use Irfan\RepositoryMaker\Console\Commands\MakeExtendedRepository;
use Irfan\RepositoryMaker\Console\Commands\MakeRepository;
use Irfan\RepositoryMaker\Console\Commands\MakeService;
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
                MakeContract::class,
                MakeBaseContract::class,
                MakeExtendedContract::class,
                MakeRepository::class,
                MakeBaseRepository::class,
                MakeExtendedRepository::class,
                MakeService::class,
            ]);
        }
    }
}
