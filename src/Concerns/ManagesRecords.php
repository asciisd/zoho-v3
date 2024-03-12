<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\modules\APIException;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\ResponseWrapper as RecordResponseWrapper;
use com\zoho\crm\api\record\SearchRecordsParam;

trait ManagesRecords
{
    public function getRecord(string $record_id): Record
    {
        return $this->handleRecordResponse(
            (new RecordOperations($this->module_api_name))->getRecord($record_id)
        )[0];
    }

    /**
     * get the records array of given module api name
     */
    public function getRecords(array $fields = ['id'], $page = 1, $perPage = 200, $sortBy = 'id', $sortOrder = 'desc'): array
    {
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

    private function handleRecordResponse($response): array
    {
        if ($response != null) {
            if (in_array($response->getStatusCode(), array(204, 304))) {
                logger()->error($response->getStatusCode() == 204 ? "No Content" : "Not Modified");

                return [];
            }

            if ($response->isExpected()) {
                $responseHandler = $response->getObject();

                if ($responseHandler instanceof RecordResponseWrapper) {
                    return $responseHandler->getData();
                } elseif ($responseHandler instanceof APIException) {
                    logger()->error($responseHandler->getMessage());
                }
            }
        }

        return [];
    }
}
