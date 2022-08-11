<?php

namespace App\Console\Commands;

use Exception;
use App\Console\Command;
use File;

class Widgets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:widget {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new widget component';

    private string $widgetPath;

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
            $this->widgetsPath = app_path() . '/Widgets/' . $name . 'Widget.php';

            if (!file_exists($this->widgetsPath)) {

                $this->createWidget($name);
                $this->info('👍 Let\'s go and use the new "' . $name . '" widget !');

            } else {

                $this->line('😑 The "' . $name . '" widget already exists.', 'yellow');
                return 0;
            }
            return 0;

        } catch (Exception $e) {

            $this->line('🤕 Something went wrong by attempting to create your new widget...', 'red');
            return 1;
        }
    }

    private function createWidget($name): void
    {
        if (!file_exists($this->widgetsPath)) {

            $widgetContent = [
                '<?php' . "\n\n",
                'namespace App\Widgets;' . "\n\n",
                'use App\Widgets\Interfaces\RenderInterface;' . "\n",
                'use App\Widgets\Traits\WidgetsTrait;' . "\n\n",
                'class ' . $name . 'Widget implements RenderInterface' . "\n",
                '{' . "\n\t",
                'use WidgetsTrait;' . "\n\n\t",
                'public static function single(int $id): ?object' . "\n\t",
                '{' . "\n\t\t",
                '// Your code...' . "\n\t",
                '}' . "\n\n\t",
                'public static function all(): ?object' . "\n\t",
                '{' . "\n\t\t",
                '// Your code...' . "\n\t",
                '}' . "\n",
                "}"
            ];

            File::put($this->widgetsPath, $widgetContent);
            $this->line('👉 "' . $name . 'Widget" has been created successfully !', 'blue');
        }
    }
}
