<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\ActionWrapper;
use com\zoho\crm\api\record\APIException;
use com\zoho\crm\api\record\BodyWrapper;
use com\zoho\crm\api\record\DeleteRecordsParam;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\SuccessResponse;
use com\zoho\crm\api\util\APIResponse;

trait ManagesActions
{
    public function create(array $args = []): SuccessResponse|array
    {
        $recordOperations = new RecordOperations($this->module_api_name);
        $bodyWrapper = new BodyWrapper();
        $records = array();
        $record = new Record();

        foreach ($args as $key => $value) {
            $record->addKeyValue($key, $value);
        }

        array_push($records, $record);

        $bodyWrapper->setData($records);

        $headerInstance = new HeaderMap();

        return $this->handleActionResponse(
            $recordOperations->createRecords($bodyWrapper, $headerInstance)
        );
    }

    private function handleActionResponse(?APIResponse $response): SuccessResponse|array
    {
        if ($response) {
            if ($response->isExpected()) {
                $actionHandler = $response->getObject();

                if ($actionHandler instanceof ActionWrapper) {
                    $actionWrapper = $actionHandler;

                    $actionResponse = $actionWrapper->getData();

                    $result = [];
                    foreach ($actionResponse as $response) {
                        if ($response instanceof SuccessResponse) {
                            $result[] = $response;
                        } else {
                            if ($response instanceof APIException) {
                                $this->handleException($response);
                            }
                        }
                    }

                    return $result;
                } else {
                    if ($actionHandler instanceof APIException) {
                        $this->handleException($actionHandler);
                    }
                }
            }
        }

        return [];
    }

    private function handleException(APIException $exception): void
    {
        $message = $exception->getMessage()->getValue();
        $details = json_encode($exception->getDetails());
        $status = $exception->getStatus()->getValue();

        logger()->error("Zoho SDK API | handleActionResponse | Status: $status | Message: $message | Details : $details");
    }

    public function update(Record $record): SuccessResponse|array
    {
        $recordOperations = new RecordOperations($this->module_api_name);
        $request = new BodyWrapper();
        $request->setData([$record]);

        return $this->handleActionResponse(
            $recordOperations->updateRecords($request)
        );
    }

    public function deleteRecord(string $record_id): SuccessResponse|array
    {
        return $this->delete([$record_id]);
    }

    public function delete(array $recordIds): SuccessResponse|array
    {
        $recordOperations = new RecordOperations($this->module_api_name);
        $paramInstance = new ParameterMap();

        foreach ($recordIds as $id) {
            $paramInstance->add(DeleteRecordsParam::ids(), $id);
        }

        return $this->handleActionResponse(
            $recordOperations->deleteRecords($paramInstance)
        );
    }
}
