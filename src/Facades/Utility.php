<?php

namespace Irfan\RepositoryMaker\Facades;
use Illuminate\Support\Facades\Facade;

class Utility extends Facade
{
    protected static function getFacadeAccessor()
    {
        // return \VendorName\Skeleton\Skeleton::class;
        return 'utility';
    }
}
