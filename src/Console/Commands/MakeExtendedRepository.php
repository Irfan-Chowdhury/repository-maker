<?php

namespace Irfan\RepositoryMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeExtendedRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-extends {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created a new repository class';

    public function handle()
    {
        $directoryPath = app_path('Repositories'); // Replace with the actual path
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // The third parameter creates nested directories if needed
            // You can also specify the desired permissions (0755 in this case)
        }

        $name = $this->argument('name');
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
use App\Models\\{$baseName};

class {$RepositoryName} extends BaseRepository implements {$contractName}
{
    protected \$model;

    public function __construct({$baseName} \$model)
    {
        \$this->\$model = \$model;
    }
}";
    }
}
