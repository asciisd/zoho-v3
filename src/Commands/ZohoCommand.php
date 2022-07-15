<?php

namespace Asciisd\Zoho\Commands;

use Illuminate\Console\Command;

class ZohoCommand extends Command
{
    public $signature = 'zoho-v3';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
