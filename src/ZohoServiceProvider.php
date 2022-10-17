<?php

namespace Asciisd\Zoho;

use Spatie\LaravelPackageTools\Package;
use Asciisd\Zoho\Commands\ZohoSetupCommand;
use Asciisd\Zoho\Commands\ZohoAuthentication;
use Asciisd\Zoho\Commands\ZohoInstallCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ZohoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
//        $package
//            ->name('zoho-v3')
//            ->hasCommands(ZohoAuthentication::class, ZohoInstallCommand::class, ZohoSetupCommand::class)
//            ->hasConfigFile('zoho')
//            ->hasRoute('web')
//            ->hasMigration('create_zohos_table');
    }
}
