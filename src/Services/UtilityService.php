<?php

namespace Irfan\RepositoryMaker\Services;
use Illuminate\Support\Facades\File;

class UtilityService
{
    public function directoryManage($directory) : void 
    {
        $directoryPath = app_path($directory); // Replace with the actual path
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // The third parameter creates nested directories if needed
            // You can also specify the desired permissions (0755 in this case)
        }
    }
}
