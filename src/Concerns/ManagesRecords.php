<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\modules\APIException;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\ResponseWrapper;
use com\zoho\crm\api\record\SearchRecordsParam;
use com\zoho\crm\api\util\APIResponse;

trait ManagesRecords
{
    public function getRecord(string $record_id): Record
    {
        return $this->handleRecordResponse(
            (new RecordOperations($this->module_api_name))->getRecord($record_id)
        )[0];
    }

    private function handleRecordResponse(?APIResponse $response): array
    {
        if ($response) {
            if ($response->isExpected()) {
                $actionHandler = $response->getObject();

                if ($actionHandler instanceof ResponseWrapper) {
                    $actionWrapper = $actionHandler;

                    $actionResponse = $actionWrapper->getData();

                    $result = [];
                    foreach ($actionResponse as $response) {
                        if ($response instanceof Record) {
                            $result[] = $response;
                        } else {
                            if ($response instanceof APIException) {
                                $this->handleRecordException($response);
                            }
                        }
                    }

                    return $result;
                } else {
                    if ($actionHandler instanceof APIException) {
                        $this->handleRecordException($actionHandler);
                    }
                }
            }
        }

        return [];
    }

    private function handleRecordException(APIException $exception): void
    {
        $message = $exception->getMessage();
        $details = json_encode($exception->getDetails());
        $status = $exception->getStatus()->getValue();

        logger()->error("Zoho SDK API | ManagesRecords | handleRecordResponse | Status: $status | Message: $message | Details : $details");
    }

    /**
     * get the records array of given module api name
     */
    public function getRecords(
        array $fields = ['id'],
        $page = 1,
        $perPage = 200,
        $sortBy = 'id',
        $sortOrder = 'desc'
    ): array {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        $paramInstance->add(GetRecordsParam::page(), $page);
        $paramInstance->add(GetRecordsParam::perPage(), $perPage);
        $paramInstance->add(GetRecordsParam::sortBy(), $sortBy);
        $paramInstance->add(GetRecordsParam::sortOrder(), $sortOrder);
        $paramInstance->add(GetRecordsParam::fields(), implode(',', $fields));

        return $this->handleRecordResponse(
            $recordOperations->getRecords($paramInstance)
        );
    }

    public function searchRecordsByCriteria(
        string $criteria,
        $page = 1,
        $perPage = 200,
        $sortBy = 'id',
        $sortOrder = 'desc'
    ): array {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        $paramInstance->add(SearchRecordsParam::criteria(), $criteria);
        $paramInstance->add(GetRecordsParam::page(), $page);
        $paramInstance->add(GetRecordsParam::perPage(), $perPage);
        $paramInstance->add(GetRecordsParam::sortBy(), $sortBy);
        $paramInstance->add(GetRecordsParam::sortOrder(), $sortOrder);

        return $this->handleRecordResponse(
            $recordOperations->searchRecords($paramInstance)
        );
    }

    public function searchRecordsByWord(
        string $word,
        $page = 1,
        $perPage = 200,
        $sortBy = 'id',
        $sortOrder = 'desc'
    ): array {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        $paramInstance->add(SearchRecordsParam::word(), $word);
        $paramInstance->add(GetRecordsParam::page(), $page);
        $paramInstance->add(GetRecordsParam::perPage(), $perPage);
        $paramInstance->add(GetRecordsParam::sortBy(), $sortBy);
        $paramInstance->add(GetRecordsParam::sortOrder(), $sortOrder);

        return $this->handleRecordResponse(
            $recordOperations->searchRecords($paramInstance)
        );
    }

    public function searchRecordsByPhone(
        string $phone,
        $page = 1,
        $perPage = 200,
        $sortBy = 'id',
        $sortOrder = 'desc'
    ): array {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        $paramInstance->add(SearchRecordsParam::phone(), $phone);
        $paramInstance->add(GetRecordsParam::page(), $page);
        $paramInstance->add(GetRecordsParam::perPage(), $perPage);
        $paramInstance->add(GetRecordsParam::sortBy(), $sortBy);
        $paramInstance->add(GetRecordsParam::sortOrder(), $sortOrder);

        return $this->handleRecordResponse(
            $recordOperations->searchRecords($paramInstance)
        );
    }

    public function searchRecordsByEmail(
        string $email,
        $page = 1,
        $perPage = 200,
        $sortBy = 'id',
        $sortOrder = 'desc'
    ): array {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        $paramInstance->add(SearchRecordsParam::email(), $email);
        $paramInstance->add(GetRecordsParam::page(), $page);
        $paramInstance->add(GetRecordsParam::perPage(), $perPage);
        $paramInstance->add(GetRecordsParam::sortBy(), $sortBy);
        $paramInstance->add(GetRecordsParam::sortOrder(), $sortOrder);

        return $this->handleRecordResponse(
            $recordOperations->searchRecords($paramInstance)
        );
    }
}
