<?php

namespace Theanh\Modules\Commands;

use Illuminate\Console\Command;
use Theanh\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class UpdateCommand extends Command
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dependencies for the specified plugin or for all plugins.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('module');

        if ($name) {
            $this->updateModule($name);

            return;
        }

        /** @var \Theanh\Modules\Plugin $module */
        foreach ($this->laravel['modules']->getOrdered() as $module) {
            $this->updateModule($module->getName());
        }
    }

    protected function updateModule($name)
    {
        $this->line('Running for plugin: <info>' . $name . '</info>');

        $this->laravel['modules']->update($name);

        $this->info("Module [{$name}] updated successfully.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be updated.'],
        ];
    }
}
