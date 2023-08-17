<?php

namespace Irfan\RepositoryMaker\Console\Commands;

use Illuminate\Console\Command;
use Irfan\RepositoryMaker\Facades\Utility;

class MakeBaseRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created a new base repository class';

    public function handle()
    {
        Utility::directoryManage($directory = 'Repositories');

        $name = 'BaseRepository';
        $baseName = str_replace('Repository', '', $name);

        $contractName = "{$baseName}Contract";
        $RepositoryName = "{$baseName}Repository";

        $repositoryContent = $this->formatOfContent($contractName, $RepositoryName, $baseName);

        $filePath = app_path("Repositories/{$RepositoryName}.php");

        if (file_exists($filePath)) {
            $this->error("Repository {$RepositoryName} already exists!");

            return;
        }

        file_put_contents($filePath, $repositoryContent);

        $this->info("Repository [app/Repositories/{$RepositoryName}.php] created successfully!");
    }

    public function formatOfContent($contractName, $RepositoryName, $baseName)
    {
        return
        "<?php

namespace App\Repositories;

use App\Contracts\\{$contractName};

class {$RepositoryName} implements {$contractName}
{
    // Interact with database.
}";
    }
}
