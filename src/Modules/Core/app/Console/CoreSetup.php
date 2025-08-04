<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CoreSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:setup';

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
        if (! Client::where('name', 'Admin Password Client')->exists()) {
            $secret = Str::random(40);
            $client = Client::create([
                'name' => 'Admin Password Client',
                'redirect_uris' => [],
                'grant_types' => ["password","refresh_token"],
                'provider' => 'admins',
                'revoked' =>  false,
                'secret' => $secret,
            ]);
            $this->updateEnvValue('ADMIN_PASSPORT_CLIENT_ID',$client->id);
            $this->updateEnvValue('ADMIN_PASSPORT_CLIENT_SECRET',$secret);
        }
    }
}
