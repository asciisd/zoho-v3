<?php

namespace Asciisd\Zoho\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Asciisd\Zoho\ZohoServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Asciisd\\Zoho\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ZohoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('zoho.application_log_file_path', __DIR__.'/../Fixture/Storage/oauth/logs/ZCRMClientLibrary.log');
        config()->set('zoho.resourcePath', __DIR__.'/../Fixture/Storage/oauth/');
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_zoho-v3_table.php.stub';
        $migration->up();
        */
    }
}
