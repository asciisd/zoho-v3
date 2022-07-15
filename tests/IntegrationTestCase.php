<?php

namespace Asciisd\Zoho\Tests;

use com\zoho\api\logger\Logger;
use com\zoho\api\logger\Levels;
use com\zoho\crm\api\Initializer;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\modules\Module;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\crm\api\SDKConfigBuilder;
use com\zoho\api\authenticator\TokenType;
use com\zoho\api\authenticator\OAuthToken;
use com\zoho\crm\api\record\ActionWrapper;
use com\zoho\crm\api\modules\ResponseWrapper;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\crm\api\modules\ModulesOperations;
use com\zoho\crm\api\record\SearchRecordsParam;
use com\zoho\crm\api\record\DeleteRecordsParam;
use com\zoho\crm\api\record\ResponseWrapper as RecordsResponseWrapper;

abstract class IntegrationTestCase extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function initialize()
    {
        $logger = Logger::getInstance(Levels::INFO, __DIR__.'/Fixture/Storage/oauth/logs/ZCRMClientLibrary.log');

        $user = new UserSignature(getenv('ZOHO_CURRENT_USER_EMAIL'));

        $environment = USDataCenter::SANDBOX();

        $token = new OAuthToken(
            getenv('ZOHO_CLIENT_ID'),
            getenv('ZOHO_CLIENT_SECRET'),
            getenv('ZOHO_TOKEN'),
            TokenType::GRANT
        );

        $token_store = new FileStore(__DIR__.'/Fixture/Storage/oauth/tokens/zcrm_oauthtokens.txt');

        $timeout           = 3;
        $connectionTimeout = 3;

        $sdkConfig = (new SDKConfigBuilder())
            ->setAutoRefreshFields(false)
            ->setPickListValidation(false)
            ->setSSLVerification(true)
            ->connectionTimeout($connectionTimeout)
            ->timeout($timeout)
            ->build();

        $resourcePath = __DIR__.'/Fixture/Storage/oauth/resources/';

        Initializer::initialize($user, $environment, $token, $token_store, $sdkConfig, $resourcePath, $logger);
    }

    public function getModule($moduleApiName): Module
    {
        $response = (new ModulesOperations())->getModule($moduleApiName);

        $responseHandler = $response->getObject();

        self::assertInstanceOf(ResponseWrapper::class, $responseHandler);

        $modules = $responseHandler->getModules();

        return $modules[0];
    }

    public function getRecord($id, $apiName): Record
    {
        $response        = (new RecordOperations())->getRecord($id, $apiName);
        $responseHandler = $response->getObject();

        self::assertInstanceOf(RecordsResponseWrapper::class, $responseHandler);

        $records = $responseHandler->getData();

        return $records[0];
    }

    public function searchRecordsByWord($name, $apiName = 'Leads'): array
    {
        $paramInstance = new ParameterMap();
        $paramInstance->add(SearchRecordsParam::word(), $name);

        $response        = (new RecordOperations())->searchRecords($apiName, $paramInstance);
        $responseHandler = $response->getObject();

        self::assertInstanceOf(RecordsResponseWrapper::class, $responseHandler);

        return $responseHandler->getData();
    }

    public function searchRecordsByPhone($phone, $apiName = 'Leads'): array
    {
        $paramInstance = new ParameterMap();
        $paramInstance->add(SearchRecordsParam::phone(), $phone);

        $response        = (new RecordOperations())->searchRecords($apiName, $paramInstance);
        $responseHandler = $response->getObject();

        self::assertInstanceOf(RecordsResponseWrapper::class, $responseHandler);

        return $responseHandler->getData();
    }

    public function deleteRecords($recordIds, $apiName='Leads')
    {
        $recordOperations = new RecordOperations();
        $paramInstance = new ParameterMap();

        foreach($recordIds as $id)
        {
            $paramInstance->add(DeleteRecordsParam::ids(), $id);
        }

        $response = $recordOperations->deleteRecords($apiName,$paramInstance);

        $actionHandler = $response->getObject();

        self::assertInstanceOf(ActionWrapper::class, $actionHandler);
    }
}
