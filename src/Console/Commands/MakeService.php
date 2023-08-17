<?php

namespace Irfan\RepositoryMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Irfan\RepositoryMaker\Facades\Utility;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created a new service class';


    public function handle()
    {
        Utility::directoryManage($directory='Services');

        $name = $this->argument('name');
        $serviceContent =
        "<?php\n\nnamespace App\Services;\n\nclass {$name}\n{\n    // Add your code here\n}";

        $filePath = app_path("Services/{$name}.php");

        if (file_exists($filePath)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        file_put_contents($filePath, $serviceContent);

        $this->info("Service [app/Services/{$name}.php] created successfully!");
    }
}
