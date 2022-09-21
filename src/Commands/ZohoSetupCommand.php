<?php

namespace Asciisd\Zoho\Commands;

use Asciisd\Zoho\Zoho;
use Illuminate\Console\Command;
use com\zoho\crm\api\exception\SDKException;

class ZohoSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:grant {token : generate grant token from https://accounts.zoho.com/developerconsole}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup zoho credentials in case you used Self-Client OAuth method';

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
     * @return mixed
     * @throws SDKException
     */
    public function handle()
    {
        $grantToken = $this->argument('token');

        if ( ! $grantToken) {
            $this->error('The Grant Token is required.');

            return 0;
        }

        Zoho::initialize($grantToken);

        $this->info('Zoho CRM has been set up successfully.');

        return 0;
    }
}
