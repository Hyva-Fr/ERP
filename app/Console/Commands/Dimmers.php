<?php

namespace App\Console\Commands;

use Exception;
use App\Console\Command;
use File;

class Dimmers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dimmer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new dimmer for dashboard page';

    private string $configPath;
    private string $dimmerPath;
    private string $bladePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $name = $this->argument('name');

            $question = 'What is your ' . $name . ' dimmer size ?';
            $blade = strtolower($name);

            $this->dimmersPath = app_path() . '/Dimmers/Containers/' . $name . '.php';
            $this->configPath = base_path() . '/config/dimmers.php';
            $this->bladePath = base_path() . '/resources/views/dimmers/containers/' . $blade . '.blade.php';

            if (!file_exists($this->bladePath)) {

                $size = $this->choice($question, ['1/1', '1/2', '1/3', '1/4', '2/3'], '1/1');
                $props = ['1/1' => '100%', '1/2' => '50%', '1/3' => '33.33%', '1/4' => '25%', '2/3' => '66.66%'];
                $this->line('Your "' . $blade . '" blade container will have a ' . $props[$size] . ' css width.', 'magenta');

            } else {

                $this->line('😑 The "' . $name . '" dimmer already exists.', 'yellow');
                return 0;
            }

            $this->createConfig();
            $this->updateDimmersList($name, $size);
            $this->createDimmer($name, $blade);
            $this->createBlade($blade);

            $this->info('👍 Let\'s go and use the new "' . $name . '" dimmer !');
            return 0;

        } catch (Exception $e) {

            $this->line('🤕 Something went wrong by attempting to create your new dimmer...', 'red');
            return 1;
        }
    }

    private function createConfig(): void
    {
        if (!file_exists($this->configPath)) {

            $configContent = [
                '<?php' . "\n\n",
                'return [' . "\n\t",
                '/*' . "\n\t",
                '|--------------------------------------------------------------------------' . "\n\t",
                '| Dimmers for dashboard' . "\n\t",
                '|--------------------------------------------------------------------------' . "\n\n\t",
                '*/' . "\n\n\t",
                '\'dimmers\' => [' . "\n\t\t",
                ']' . "\n",
                '];'
            ];

            File::put($this->configPath, $configContent);
            $this->line('👉 "config/dimmer.php" has been created successfully !', 'blue');
        }
    }

    private function createDimmer($name, $blade): void
    {
        if (!file_exists($this->dimmersPath)) {

            $dimmerContent = [
                '<?php' . "\n\n",
                'namespace App\Dimmers\Containers;' . "\n\n",
                'use App\Dimmers\DimmerInterface\RenderInterface;' . "\n\n",
                'class ' . $name . ' implements RenderInterface' . "\n",
                '{' . "\n\t",
                'public function index()' . "\n\t",
                '{' . "\n\t\t",
                'return view(\'dimmers.containers.' . $blade . '\');' . "\n\t",
                '}' . "\n",
                "}"
            ];

            File::put($this->dimmersPath, $dimmerContent);
            $this->line('👉 "' . $name . '" dimmer class has been created successfully !', 'blue');
        }
    }

    private function createBlade($blade): void
    {
        if (!file_exists($this->bladePath)) {

            $bladeContent = [
                '<div class="dimmers" id="' . $blade . '-dimmer">' . "\n\t",
                '<!-- Your code... -->' . "\n",
                '</div>'
            ];

            File::put($this->bladePath, $bladeContent);
            $this->line('👉 "resources/views/dimmers/containers/' . $blade . '.blade.php" file has been created successfully !', 'blue');
        }
    }

    private function updateDimmersList($name, $size): void
    {
        if (!file_exists($this->dimmersPath)) {

            $configContent = [
                '<?php' . "\n\n",
                'return [' . "\n\t",
                '/*' . "\n\t",
                '|--------------------------------------------------------------------------' . "\n\t",
                '| Dimmers for dashboard' . "\n\t",
                '|--------------------------------------------------------------------------' . "\n\n\t",
                '*/' . "\n\n\t",
                '\'dimmers\' => [' . "\n",
                $this->parseDimmers($name, $size) . "\t",
                ']' . "\n",
                '];'
            ];

            File::put($this->configPath, $configContent);
            $this->line('👉 "config/dimmer.php" has been updated successfully !', 'blue');
        }
    }

    private function parseDimmers($name, $size): string
    {
        $originalDimmers = config('dimmers.dimmers');
        $newConfig = [
            'class' => 'App\\Dimmers\\Containers\\' . $name,
            'size' => $size
        ];
        $originalDimmers[] = $newConfig;
        $content = '';

        foreach ($originalDimmers as $dimmer) {

            $class = str_replace('\\', '\\\\', $dimmer['class']);
            $content .=  "\t\t" . '[' . "\n\t\t\t";
            $content .= '\'class\' => \'' . $class . '\',' . "\n\t\t\t";
            $content .= '\'size\' => \'' . $dimmer['size'] . '\'' . "\n\t\t";
            $content .= '],' . "\n";
        }
        return $content;
    }
}
