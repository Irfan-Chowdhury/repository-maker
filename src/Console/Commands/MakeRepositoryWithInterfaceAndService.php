<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryWithInterfaceAndService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-i-s {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class with interface and service';

    public function handle()
    {
        $name = $this->argument('name');
        $baseName = str_replace('Repository', '', $name);

        $contractName = "{$baseName}Contract";
        $repositoryName = "{$baseName}Repository";
        $serviceName = "{$baseName}Service";

        $this->makeContract($contractName);
        $this->makeRepository($baseName, $contractName, $repositoryName);
        $this->makeService($contractName, $serviceName);
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
        if(config('database.connections.peopleprosaas_landlord')) {
            $modelPath = "App\Models\Landlord\\{$baseName}";
        }else {
            $modelPath = "App\Models\{$baseName}";
        }

        $repositoryContent = $this->formatOfRepositoryContent($contractName, $modelPath, $repositoryName, $baseName);

        $filePath = app_path("Repositories/{$repositoryName}.php");

        if (file_exists($filePath)) {
            $this->error("Repository {$repositoryName} already exists!");
            return;
        }

        file_put_contents($filePath, $repositoryContent);

        $this->info("Repository [app/Repositories/{$repositoryName}.php] created successfully!");
    }

    protected function makeService($contractName, $serviceName)
    {
        $serviceContent = $this->formatOfServiceContent($contractName, $serviceName);

        $filePath = app_path("Services/{$serviceName}.php");

        if (file_exists($filePath)) {
            $this->error("Service {$serviceName} already exists!");
            return;
        }

        file_put_contents($filePath, $serviceContent);

        $this->info("Service [app/Services/{$serviceName}.php] created successfully!");
    }


    public function formatOfRepositoryContent($contractName, $modelPath, $repositoryName, $baseName)
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


    public function formatOfServiceContent($contractName, $serviceName)
    {
        $variableName = lcfirst($contractName);

return
"<?php

namespace App\Services;

use App\Contracts\\{$contractName};

class {$serviceName}
{
    public function __construct(private {$contractName} \${$variableName}) {}

}";
    }


    public function bindAdd()
    {

        $providerFilePath = app_path('Providers/AppServiceProvider.php');
        $interfaceClass = 'App\Contracts\TestSettingContract';
        $repositoryClass = 'App\Repositories\TestSettingRepository';

        if (file_exists($providerFilePath)) {
            $providerContent = file_get_contents($providerFilePath);

            // Check if the binding is not already added
            if (strpos($providerContent, $interfaceClass) === false) {
                // Add the binding line to the content
                $bindingLine = "\$this->app->bind($interfaceClass, $repositoryClass);";
                $newContent = preg_replace(
                    '/public\s+function\s+register\(\)\s*{/',
                    "public function register()\n    {\n        $bindingLine\n",
                    $providerContent
                );

                // Write the updated content back to the file
                file_put_contents($providerFilePath, $newContent);

                $this->info("Binding added successfully.");
            } else {
                $this->error("Binding already exists.");
                return;
            }
        } else {
            $this->error("AppServiceProvider file not found.");
            return;
        }

    }

}

