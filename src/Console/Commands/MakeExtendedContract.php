<?php

namespace Irfan\RepositoryMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeExtendedContract extends Command
{
    protected $signature = 'make:contract-extends {name}';  // -e => extends

    protected $description = 'Create an extended contract interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directoryPath = app_path('Contracts');
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // The third parameter creates nested directories if needed
        }

        $name = $this->argument('name');
        $contractContent = $this->formatOfContent($name);

        $filePath = app_path("Contracts/{$name}.php");

        if (file_exists($filePath)) {
            $this->error("Contract {$name} already exists!");
            return;
        }

        file_put_contents($filePath, $contractContent);

        $this->info("Contract [app/Contracts/{$name}.php] created successfully!");
    }


    private function formatOfContent($name)
    {
        return
"<?php

namespace App\Contracts;

interface {$name} extends BaseContract
{
    // Add your signature here
}";

    }
}
