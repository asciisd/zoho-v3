<?php

namespace Asciisd\Zoho\Commands;

use Asciisd\Zoho\Zoho;
use com\zoho\crm\api\exception\SDKException;
use Illuminate\Console\Command;

class ZohoSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'zoho:grant {token? : generate grant token from https://accounts.zoho.com/developerconsole}';

    /**
     * The console command description.
     */
    protected $description = 'Setup zoho credentials in case you used Self-Client OAuth method';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws SDKException
     */
    public function handle()
    {
        $grantToken = $this->argument('token') ?? config('zoho.token');

        if (!$grantToken) {
            $this->error('The Grant Token is required.');
            $this->info('generate token by visit : https://accounts.zoho.com/developerconsole');

            return 0;
        }

        $this->info('Token: '.$grantToken);

        Zoho::initialize($grantToken);

        $this->info('Zoho CRM has been set up successfully.');

        return 0;
    }
}
