<?php

namespace Asciisd\Zoho\Tests\Integration;

use Asciisd\Zoho\Zoho;
use com\zoho\api\logger\Levels;
use Asciisd\Zoho\Tests\TestCase;
use com\zoho\api\logger\LogBuilder;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\SDKConfigBuilder;
use com\zoho\crm\api\InitializeBuilder;
use Asciisd\Zoho\Tests\Fixture\Models\User;
use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\api\authenticator\store\FileStore;

abstract class IntegrationTestCase extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function initialize()
    {
        $logger = (new LogBuilder())->level(Levels::INFO)
                                    ->filePath(__DIR__.'/../Fixture/Storage/oauth/logs/ZCRMClientLibrary.log')
                                    ->build();

        $user = new UserSignature(getenv('ZOHO_CURRENT_USER_EMAIL'));

        $environment = Zoho::getDataCenterEnvironment();

        $token = (new OAuthBuilder())
            ->clientId(getenv('ZOHO_CLIENT_ID'))
            ->clientSecret(getenv('ZOHO_CLIENT_SECRET'))
            ->grantToken(getenv('ZOHO_TOKEN'))
            ->redirectURL(getenv('ZOHO_REDIRECT_URI'))
            ->build();

        $token_store = new FileStore(__DIR__.'/../Fixture/Storage/oauth/tokens/zcrm_oauthtokens.txt');
        $connectionTimeout = 3;
        $timeout = 10;

        $sdkConfig = (new SDKConfigBuilder())
            ->autoRefreshFields(false)
            ->pickListValidation(false)
            ->sslVerification(true)
            ->connectionTimeout($connectionTimeout)
            ->timeout($timeout)
            ->build();

        $resourcePath = __DIR__.'/../Fixture/Storage/oauth/';

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

    public function getUser(): User
    {
        return new User([
            'first_name' => 'Create',
            'last_name'  => 'From User',
            'email'      => 'user@asciisd.com',
            'phone'      => '555555555551',
        ]);
    }
}
