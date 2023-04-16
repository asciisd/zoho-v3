<?php


namespace Asciisd\Zoho\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ZohoInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'zoho:install';

    /**
     * The console command description.
     */
    protected $description = 'Install Zoho resources';

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
    public function handle()
    {
        $this->comment('Generate Zoho OAuth files ...');
        Storage::disk('local')->put('zoho/oauth/logs/ZCRMClientLibrary.log', '');
        Storage::disk('local')->put('zoho/oauth/tokens/zcrm_oauthtokens.txt', '');

        $this->info('Zoho scaffolding installed successfully.');
    }
}
