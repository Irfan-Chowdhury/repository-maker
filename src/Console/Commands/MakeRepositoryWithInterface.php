<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryWithInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-i {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class with interface';

    public function handle()
    {
        $name = $this->argument('name');
        $baseName = str_replace('Repository', '', $name);

        $contractName = "{$baseName}Contract";
        $repositoryName = "{$baseName}Repository";

        $this->makeContract($contractName);
        $this->makeRepository($baseName, $contractName, $repositoryName);
    }



    protected function makeContract($contractName)
    {
        $contractContent = "<?php\n\nnamespace App\Contracts;\n\ninterface {$contractName} extends BaseContract\n{\n    // Add your signature here\n}";

        $filePath = app_path("Contracts/{$contractName}.php");

        if (file_exists($filePath)) {
            $this->error("Contract {$contractName} already exists!");
            return;
        }

        file_put_contents($filePath, $contractContent);

        $this->info("Contract [app/Contracts/{$contractName}.php] created successfully!");
    }

    protected function makeRepository($baseName, $contractName, $repositoryName)
    {
        $modelPath = "App\Models\{$baseName}";

        // $repositoryContent = "<?php\n\nnamespace App\Repositories;\n\nuse App\Contracts\\{$contractName};\nuse $modelPath;\n\nclass {$repositoryName} extends BaseRepository implements {$contractName}\n{\n    protected \$model;\n\n    public function __construct(Social \$model)\n    {\n        \$this->\$model = \$model;\n        parent::__construct(\$this->\$model);\n    }\n}";
        $repositoryContent = $this->formatOfContent($contractName, $modelPath, $repositoryName, $baseName);

        $filePath = app_path("Repositories/{$repositoryName}.php");

        if (file_exists($filePath)) {
            $this->error("Repository {$repositoryName} already exists!");
            return;
        }

        file_put_contents($filePath, $repositoryContent);

        $this->info("Repository [app/Repositories/{$repositoryName}.php] created successfully!");
    }


    public function formatOfContent($contractName, $modelPath, $repositoryName, $baseName)
    {
return
"<?php

namespace App\Repositories;

use App\Contracts\\{$contractName};
use $modelPath;

class {$repositoryName} extends BaseRepository implements {$contractName}
{
    protected \$model;

    public function __construct({$baseName} \$model)
    {
        \$this->\$model = \$model;
        parent::__construct(\$this->\$model);
    }
}";
    }

}

