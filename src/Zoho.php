<?php

namespace Asciisd\Zoho;

use com\zoho\api\logger\Levels;
use com\zoho\api\logger\LogBuilder;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\SDKConfigBuilder;
use com\zoho\crm\api\InitializeBuilder;
use com\zoho\crm\api\exception\SDKException;
use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\api\authenticator\store\FileStore;

class Zoho
{
    /**
     * The Zoho library version.
     */
    public const VERSION = '1.0.0';

    /**
     * Indicates if Zoho migrations will be run.
     */
    public static bool $runsMigrations = true;

    /**
     * Indicates if Zoho routes will be registered.
     */
    public static bool $registersRoutes = true;

    /**
     * Configure Zoho to not register its migrations.
     */
    public static function ignoreMigrations(): static
    {
        static::$runsMigrations = false;

        return new static();
    }

    /**
     * Configure Zoho to not register its routes.
     */
    public static function ignoreRoutes(): static
    {
        static::$registersRoutes = false;

        return new static();
    }

    /**
     * @throws SDKException
     */
    public static function initialize($code = null): void
    {
        $environment = config('zoho.environment');
        $resourcePath = config('zoho.resourcePath');
        $user = new UserSignature(config('zoho.current_user_email'));
        $token_store = new FileStore(config('zoho.token_persistence_path'));
        $logger = (new LogBuilder())->level(Levels::ALL)
                                    ->filePath(config('zoho.application_log_file_path'))
                                    ->build();

        $token = (new OAuthBuilder())
            ->clientId(config('zoho.client_id'))
            ->clientSecret(config('zoho.client_secret'))
            ->grantToken($code ?? config('zoho.token'))
            ->redirectURL(config('zoho.redirect_uri'))
            ->build();

        $sdkConfig = (new SDKConfigBuilder())
            ->autoRefreshFields(config('zoho.autoRefreshFields'))
            ->pickListValidation(config('zoho.pickListValidation'))
            ->sslVerification(config('zoho.enableSSLVerification'))
            ->connectionTimeout(config('zoho.connectionTimeout'))
            ->timeout(config('zoho.timeout'))
            ->build();


        (new InitializeBuilder())
            ->user($user)
            ->environment($environment)
            ->token($token)
            ->store($token_store)
            ->SDKConfig($sdkConfig)
            ->resourcePath($resourcePath)
            ->logger($logger)
            ->initialize();
    }
}
