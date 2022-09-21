<?php

namespace Asciisd\Zoho;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Asciisd\Zoho\Commands\ZohoCommand;

class ZohoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('zoho-v3')
            ->hasCommands('ZohoAuthentication', 'ZohoInstallCommand', 'ZohoSetupCommand')
            ->hasConfigFile('zoho')
            ->hasRoute('web')
            ->hasMigration('create_zohos_table');
    }
}
