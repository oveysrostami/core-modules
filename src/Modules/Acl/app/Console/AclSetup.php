<?php

namespace Modules\Acl\Console;


use Illuminate\Support\Facades\File;
use Modules\Core\Console\ModuleSetup;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AclSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'acl:setup';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('permissions:sync');
        $this->call('roles:sync');
        $this->info('Acl setup complete.');
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    protected function getModuleName(): string
    {
        return 'Acl';
    }
}
