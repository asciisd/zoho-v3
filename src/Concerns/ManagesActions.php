<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\modules\APIException;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\ActionWrapper;
use com\zoho\crm\api\record\BodyWrapper;
use com\zoho\crm\api\record\DeleteRecordsParam;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\SuccessResponse;
use com\zoho\crm\api\util\APIResponse;
use com\zoho\crm\api\util\Choice;

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

    private function handleActionResponse(?APIResponse $response): SuccessResponse|array
    {
        if ($response != null) {
            logger()->info("Zoho SDK API | handleActionResponse | Status Code: " . $response->getStatusCode());
            if (in_array($response->getStatusCode(), array(204, 304))) {
                logger()->error($response->getStatusCode() == 204 ? "Zoho SDK API | handleActionResponse | No Content" : "Zoho SDK API | handleActionResponse | Not Modified");

                return [];
            }

            if ($response->isExpected()) {
                $actionHandler = $response->getObject();

                if ($actionHandler instanceof ActionWrapper) {
                    $actionWrapper = $actionHandler;
                    $actionResponse = $actionWrapper->getData()[0];

                    if ($actionResponse instanceof SuccessResponse) {
                        return $actionResponse;
                    } else {
                        if ($actionResponse instanceof APIException) {
                            $exception = $actionResponse;

                            logger()->error("Zoho SDK API | handleActionResponse | Message : ", $exception->getMessage() instanceof Choice ? $exception->getMessage()->getValue() : $exception->getMessage());
                        }
                    }
                } else {
                    if ($actionHandler instanceof APIException) {
                        $exception = $actionHandler;

                        logger()->error("Zoho SDK API | handleActionResponse | Message : ", $exception->getMessage() instanceof Choice ? $exception->getMessage()->getValue() : $exception->getMessage());
                    }
                }
            }
        }

        return [];
    }
}
