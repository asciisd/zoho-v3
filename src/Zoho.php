<?php

namespace Asciisd\Zoho;

use com\zoho\api\logger\Logger;
use com\zoho\api\logger\Levels;
use com\zoho\crm\api\Initializer;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\SDKConfigBuilder;
use com\zoho\api\authenticator\TokenType;
use com\zoho\api\authenticator\OAuthToken;
use com\zoho\crm\api\exception\SDKException;
use com\zoho\api\authenticator\store\FileStore;

class Zoho
{
    /**
     * The Zoho library version.
     *
     * @var string
     */
    const VERSION = '1.2.10';

    /**
     * Indicates if Zoho migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Indicates if Zoho routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * Configure Zoho to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;

        return new static;
    }

    /**
     * Configure Zoho to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;

        return new static;
    }

    /**
     * @throws SDKException
     */
    public static function initialize($code): void
    {
        $logger = Logger::getInstance(Levels::INFO, config('zoho.application_log_file_path'));

        $user = new UserSignature(config('zoho.current_user_email'));

        $environment = config('zoho.environment');

        $token = new OAuthToken(
            config('zoho.client_id'),
            config('zoho.client_secret'),
            $code,
            TokenType::GRANT,
            config('zoho.redirect_uri')
        );

        $token_store = new FileStore(config('zoho.token_persistence_path'));

        $autoRefreshFields = config('zoho.autoRefreshFields');

        $pickListValidation = config('zoho.pickListValidation');

        $connectionTimeout = config('zoho.connectionTimeout');

        $enableSSLVerification = config('zoho.enableSSLVerification');

        $timeout = config('zoho.timeout');

        $sdkConfig = (new SDKConfigBuilder())->setAutoRefreshFields($autoRefreshFields)
                                             ->setPickListValidation($pickListValidation)
                                             ->setSSLVerification($enableSSLVerification)
                                             ->connectionTimeout($connectionTimeout)->timeout($timeout)->build();

        $resourcePath = config('zoho.resourcePath');

        Initializer::initialize($user, $environment, $token, $token_store, $sdkConfig, $resourcePath, $logger);
    }
}
